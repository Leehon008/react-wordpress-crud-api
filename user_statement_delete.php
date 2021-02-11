<?php
//echo "user_statement delete";
function user_statement_delete(){
    echo "employee delete";
    if(isset($_GET['userId'])){
         $i=$_GET['userId'];
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_statement';
        $wpdb->delete(
            $table_name,
            array('userId'=>$i)
        );
        echo "deleted user_statement: $i";
    }
    echo get_site_url() .'/wp-admin/admin.php?page=User_Statement_Listing';
    ?>
    <meta http-equiv="refresh" content="0; url=http://localhost/rest-wp-app/wp-admin/admin.php?page=User_Statement_Listing" />
    <?php
    //wp_redirect( admin_url('admin.php?page=page=Employee_List'),301 );
    //exit;
    //header("location:http://localhost/wordpressmyplugin/wordpress/wp-admin/admin.php?page=User_Statement_Listing");
}
?>