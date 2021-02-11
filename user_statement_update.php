<?php
//echo "update page";
function user_statement_update()
{
    //echo "update page in";
    $i = $_GET['userId'];
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_statement';
    $userStatements = $wpdb->get_results("SELECT userId,memo,debit,credit,created from $table_name where userId=$i");
    echo $userStatements[0]->userId;
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
                <input type="hidden" name="userId" value="<?= $userStatements[0]->userId; ?>">
                <tr>
                    <td>Memo:</td>
                    <td><input type="text" name="memo" value="<?= $userStatements[0]->memo; ?>"></td>
                </tr>
                <tr>
                    <td>Debit:</td>
                    <td><input type="text" name="debit" value="<?= $userStatements[0]->debit; ?>"></td>
                </tr>
                <tr>
                    <td>Credit:</td>
                    <td><input type="text" name="credit" value="<?= $userStatements[0]->credit; ?>"></td>

                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Update" name="upd"></td>
                </tr>
            </form>
        </tbody>
    </table>
<?php
}
if (isset($_POST['upd'])) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_statement';
    $userId = $_POST['userId'];
    $memo = $_POST['memo'];
    $debit = $_POST['debit'];
    $credit = $_POST['credit'];
    $wpdb->update(
        $table_name,
        array(
            'memo' => $memo,
            'debit' => $debit,
            'credit' => $credit
        ),
        array(
            'userId' => $userId
        )
    );
    $url = admin_url('admin.php?page=User_Statement_Listing');
    header("location:http://localhost/rest-wp-app/wp-admin/admin.php?page=User_Statement_Listing");
}
?>