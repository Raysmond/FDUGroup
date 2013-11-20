<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 * Date: 13-10-18
 * Time: PM5:21
 * To change this template use File | Settings | File Templates.
 */
?>

    <div class="panel panel-default">
        <?=RFormHelper::openForm('user/admin',array('id'=>'blockUserForm'))?>
        <!-- Default panel contents -->
        <div class="panel-heading">
            Users
            <div class="navbar-right">
                <a class='btn btn-sm btn-danger' href="javascript:block_submit()">Block</a>
                <a class='btn btn-sm btn-success' href="javascript:active_submit()">Active</a>
                <?=RFormHelper::hidden(array('id'=>'operation_type','name'=>'operation_type','value'=>'block'))?>
            </div>
        </div>
        <!-- Table -->

        <table id="admin-users" class="table">
            <thead>
            <tr>
                <?php
                $skips = array('id', 'weibo', 'password', 'intro', 'credits', 'permission', 'privacy', 'picture');
                echo '<th><input id="check-all" name="check-all" onclick="javascript:checkReverse(\'checked_users[]\');" type="checkbox" /></th>';
                foreach (User::$labels as $key => $label) {
                    if (in_array($key, $skips)) continue;
                    echo '<th>' . $label . '</th>';
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $user) {
                echo '<tr>';
                ?><td><?=RFormHelper::input(array('name'=>'checked_users[]', 'type'=>'checkbox','value'=>$user->id))?></td><?php
                foreach ($user->columns as $objCol => $dbcol) {
                    if (in_array($objCol, $skips)) continue;
                    echo '<td>';
                    switch ($objCol) {
                        case "roleId":
                            echo Role::getRoleNameById($user->$objCol);
                            break;
                        case "name":
                            echo RHtmlHelper::linkAction('user', $user->$objCol, 'view', $user->id);
                            break;
                        case "homepage":
                            echo RHtmlHelper::link($user->$objCol, $user->$objCol, $user->$objCol);
                            break;
                        case "status":
                            if ($user->status == 1) echo '<span style="color:green">active</span>';
                            else echo '<span style="color:red">blocked</span>';
                            break;
                        default:
                            echo $user->$objCol;
                    }
                    echo '</td>';
                }
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <?=RFormHelper::endForm();?>
    </div>

<?= (isset($pager) ? $pager : '') ?>
<script>
    function block_submit() {
        $("#operation_type").val('block');
        $('#blockUserForm').submit();
    }

    function active_submit() {
        $("#operation_type").val('active');
        $('#blockUserForm').submit();
    }


</script>