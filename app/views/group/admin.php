<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 */
?>
<?=RFormHelper::openForm('group/admin',array('id'=>'groupAdminForm'))?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        <div class="heading-actions">
            <div class="input-group" style="margin-top: -6px;">
                <?=RFormHelper::input(array('name'=>'search','class'=>'form-control','style'=>'width:200px;','placeholder'=>'filter groups','value'=>(isset($filterStr)?$filterStr:"")))?>
                <div style="float: right; margin-left: -1px;">
                    <button class="btn btn-default" type="submit">Go!</button>
                    &nbsp;&nbsp;
                    <input type="submit" onclick="return confirm('Are you sure to delete selected groups?')" value="Delete" class="btn btn-xs btn-danger" />
                </div>
            </div>
        </div>
        <h1 class="panel-title">Groups</h1>
    </div>

    <div class="panel-body">
        <!-- Table -->
        <table id="admin-users" class="table">
            <thead>
            <tr>
                <?php
                $skips = array("intro");
                echo '<th><input id="check-all" name="check-all" onclick="javascript:checkReverse(\'checked_groups[]\')" type="checkbox" /></th>';
                foreach (Group::$labels as $key => $label) {
                    if (in_array($key, $skips)) continue;
                    echo '<th>' . $label . '</th>';
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php

            // That's bad to load user names and category names for each group
            // Need to be fixed. It's better to add "join" support in the database models

            foreach ($groups as $group) {
                echo '<tr>';
                echo '<td><input name="checked_groups[]" type="checkbox" value="$group->id" /></td>';
                echo "<td>$group->id</td>";
                echo '<td>'.RHtmlHelper::linkAction('user', $group->groupCreator->name, 'view', $group->groupCreator->id).'</td>';
                echo '<td>'.RHtmlHelper::linkAction('category', $group->category->name, 'groups', $group->category->id).'</td>';
                echo '<td>'.RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id).'</td>';
                echo "<td>$group->memberCount</td>";
                echo "<td>$group->createdTime</td>";
                if (isset($group->picture) && $group->picture != '') {
                    $picture = RImageHelper::styleSrc($group->picture, Group::getPicOptions());
                    echo '<td>'.RHtmlHelper::showImage($picture, $group->name, array("style"=>'width:64px;')).'</td>';
                }
                else{
                    echo '<td></td>';
                }
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>

        <?= (isset($pager) ? $pager : '') ?>
    </div>

</div>
<?=RFormHelper::endForm()?>
