<?php

function user_statement_list()
{
?>
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        td,
        th {
            border: 1px stripped black;
            padding: 20px;
            text-align: center;
        }
    </style>
    <div class="wrap">
        <div class="row">
            <div class="col-12 col-md-8">
                <p>
                    <?php
                    $current_user = wp_get_current_user();
                    echo $current_user->display_name;

                    ?>
                <p>Customer Statement</p>
                </p>
            </div>
            <div class="col-12 col-md-4">
                <select name="stat_sele" id="">
                    <option value="USD">USD</option>
                    <option value="ZW">ZW</option>
                </select>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Created On</th>
                    <th>UserID</th>
                    <th>Memo</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Balance</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                global $wpdb;
                $table_name = $wpdb->prefix . 'user_statement';
                $userStatements = $wpdb->get_results("SELECT userId,memo,debit,credit,created from $table_name "); //WHERE userId =$current_user_id");

                foreach ($userStatements as $userStatement) {
                ?>
                    <tr>
                        <td><?= $userStatement->created; ?></td>
                        <td><?= $userStatement->userId; ?></td>
                        <td><?= $userStatement->memo; ?></td>
                        <td><?= $userStatement->debit; ?></td>
                        <td><?= $userStatement->credit; ?></td>
                        <td><?= (($userStatement->debit) - ($userStatement->credit)); ?></td>
                        <td><a href="<?php echo admin_url('admin.php?page=User_Statement_Update&userId=' . $userStatement->userId); ?>">Update</a> </td>
                        <td><a href="<?php echo admin_url('admin.php?page=User_Statement_Delete&userId=' . $userStatement->userId); ?>"> Delete</a></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
<?php

}
add_shortcode('short_userStatement_list', 'userStatement_list');
?>