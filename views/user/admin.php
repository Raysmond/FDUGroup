<?php
/**
 * @author: Raysmond
 */
?>
<?=RForm::openForm('user/admin',array('id'=>'blockUserForm'))?>
    <div class="panel panel-default">

        <!-- Default panel contents -->
        <div class="panel-heading">
            <div class="heading-actions">
                <div class="input-group">
                    <?=RForm::input(array('name'=>'search','class'=>'form-control','style'=>'width:200px;','placeholder'=>'filter users','value'=>(isset($filterStr)?$filterStr:"")))?>
                    <button class="btn btn-default" type="submit">Go!</button>
                    &nbsp;&nbsp;
                    <a class='btn btn-xs btn-danger' href="javascript:block_submit()">Block</a>
                    &nbsp;&nbsp;
                    <a class='btn btn-xs btn-success' href="javascript:active_submit()">Activate</a>
                    <?=RForm::hidden(array('id'=>'operation_type','name'=>'operation_type','value'=>'block'))?>
                </div>

            </div>

            <h1 class="panel-title">Users</h1>

        </div>

        <div class="panel-body">

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
                    ?><td><?=RForm::input(array('name'=>'checked_users[]', 'type'=>'checkbox','value'=>$user->id))?></td><?php
                    foreach (User::$mapping as $objCol => $dbcol) {
                        if (in_array($objCol, $skips)) continue;
                        echo '<td>';
                        switch ($objCol) {
                            case "roleId":
                                echo Role::getRoleNameById($user->$objCol);
                                break;
                            case "name":
                                echo RHtml::linkAction('user', $user->$objCol, 'view', $user->id);
                                break;
                            case "homepage":
                                echo RHtml::link($user->$objCol, $user->$objCol, $user->$objCol);
                                break;
                            case "gender":
                                echo User::getGenderName($user->gender);
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
            <?= (isset($pager) ? $pager : '') ?>
        </div>
    </div>
<?=RForm::endForm();?>

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