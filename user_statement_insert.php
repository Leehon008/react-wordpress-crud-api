<?php

function user_statement_insert()
{
    //echo "insert page";
?>
    <table>
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <form name="frm" action="#" method="post">
                <tr>
                    <td>Memo:</td>
                    <td><input type="text" name="memo"></td>
                </tr>
                <tr>
                    <td>Debit:</td>
                    <td><input type="text" name="deb"></td>
                </tr>
                <tr>
                    <td>Credit:</td>
                    <td><input type="text" name="cred"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Insert" name="ins"></td>
                </tr>
            </form>
        </tbody>
    </table>
    <?php
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
        // wp_redirect( admin_url('admin.php?page=page=Employee_List'),301 );

        //header("location:http://localhost/wordpressmyplugin/wordpress/wp-admin/admin.php?page=Employee_Listing");
        //  header("http://google.com");
    ?>
        <meta http-equiv="refresh" content="1; 
        url=http://localhost/rest-wp-app/wp-admin/admin.php?page=User_Statement_Listing" />
<?php
        exit;
    }
}

?>