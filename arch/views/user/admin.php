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
        <!-- Default panel contents -->
        <div class="panel-heading">
            Users
            <div class="navbar-right">
                <a class="btn btn-sm btn-danger" title="Delete" href="javascript:delete_users()">Delete</a>
            </div>
        </div>

        <!-- Table -->
        <table id="admin-users" class="table">
            <thead>
            <tr>
                <?php
                $skips = array('id', 'weibo', 'password', 'intro', 'credits', 'permission', 'privacy', 'picture');
                echo '<th><input id="check-all" name="check-all" onclick="javascript:change_check()" type="checkbox" /></th>';
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
                echo '<td><input name="checked_users" type="checkbox" /></td>';
                foreach ($user->columns as $objCol => $dbcol) {
                    if (in_array($objCol, $skips)) continue;
                    echo '<td>';
                    switch ($objCol) {
                        case "roleId":
                            echo Role::$Roles[$user->$objCol];
                            break;
                        case "name":
                            echo RHtmlHelper::linkAction('user', $user->$objCol, 'view', $user->id);
                            break;
                        case "homepage":
                            echo RHtmlHelper::link($user->$objCol, $user->$objCol, $user->$objCol);
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
    </div>

<?= (isset($pager) ? $pager : '') ?>
<script>

    function change_check(){
        $("input[name='checked-users']").attr("checked",$("#check-all").attr("checked"));
    }

</script>