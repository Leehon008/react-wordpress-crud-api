<?php

/**
 * @wordpress-plugin
 * Plugin Name: Embedding React app to Wordpress widget
 * Author: Leehon008
 * Description: This will allow React to interact with WordPress later in the pages using ShortCode syntax.
 */

defined('ABSPATH') or die('Direct script access disallowed.');

define('ERW_WIDGET_PATH', plugin_dir_path(__FILE__) . '/react_widget');
define('ERW_ASSET_MANIFEST', ERW_WIDGET_PATH . '/build/asset-manifest.json');
define('ERW_INCLUDES', plugin_dir_path(__FILE__) . '/includes');

require_once(ERW_INCLUDES . '/enqueue.php');
require_once(ERW_INCLUDES . '/shortcode.php');

/* 
create table on plugin activation
*/

global $jal_db_version;
$jal_db_version = '1.0';

function create_table_on_plugin_install()
{
    global $wpdb;
    global $jal_db_version;

    $table_name = $wpdb->prefix . 'user_statement';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
		userId int(9) NOT NULL AUTO_INCREMENT,
		memo varchar(4000) NOT NULL,
		debit decimal NOT NULL,
		credit decimal NOT NULL,
		created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 		PRIMARY KEY (`userId`)
	) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('jal_db_version', $jal_db_version);
}
register_activation_hook(__FILE__, 'create_table_on_plugin_install');

//add new rest api endpoint 
add_action('rest_api_init', function () {
    register_rest_route(
        'sap/v1',
        '/statement/(?P<userId>\d+)',
        array(
            array(
                'methods' => 'GET',
                'callback' => 'get_statement',
                'args' => array(
                    'userId' => array(
                        'validate_callback' => 'is_numeric'
                    ),
                ),
                'permission_callback' => function () {
                    return current_user_can('edit_others_posts');
                }
            ),
            array(
                'methods' => 'POST',
                'callback' => 'set_statement',
                'permission_callback' => function () {
                    return current_user_can('edit_others_posts');
                }
            )
        )
    );
});

function get_statement($data)
{
    return json_decode(get_option('statement', $default = '[]'));
}

function set_statement($data)
{
    if (isset($_POST['ins'])) {
        global $wpdb;
        $memo = $_POST['memo'];
        $ad = $_POST['deb'];
        $cred = $_POST['cred'];
        $table_name = $wpdb->prefix . 'user_statement';

        $wpdb->insert(
            $table_name,
            array(
                'memo' => $memo,
                'debit' => $ad,
                'credit' => $cred,
            )
        );
        echo "inserted a user statement record";
    }
}

//adding in menu
add_action('admin_menu', 'at_try_menu');

function at_try_menu()
{
    //adding plugin in menu
    add_menu_page(
        'user_statement_list', //page title
        'User Statement Listing', //menu title
        'manage_options', //capabilities
        'User_Statement_Listing', //menu slug
        'user_statement_list' //function
    );
    //adding submenu to a menu
    add_submenu_page(
        'User_Statement_Listing', //parent page slug
        'user_statement_insert', //page title
        'User Statement Insert', //menu title
        'manage_options', //manage optios
        'User_Statement_Insert', //slug
        'user_statement_insert' //function
    );
    add_submenu_page(
        null, //parent page slug
        'user_statement_update', //$page_title
        'User Statement Update', // $menu_title
        'manage_options', // $capability
        'User_Statement_Update', // $menu_slug,
        'user_statement_update' // $function
    );
    add_submenu_page(
        null, //parent page slug
        'user_statement_delete', //$page_title
        'User Statement Delete', // $menu_title
        'manage_options', // $capability
        'User_Statement_Delete', // $menu_slug,
        'user_statement_delete' // $function
    );
}


// returns the root directory path of particular plugin
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'user_statement_list.php');
require_once(ROOTDIR . 'user_statement_insert.php');
require_once(ROOTDIR . 'user_statement_update.php');
require_once(ROOTDIR . 'user_statement_delete.php');
