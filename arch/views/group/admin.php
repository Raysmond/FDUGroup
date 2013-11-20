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
        Groups
        <div class="navbar-right">
            <?=RFormHelper::input(array('type'=>'submit','value'=>'Delete','class'=>'btn btn-sm btn-danger'))?>
        </div>
    </div>

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

        foreach ($groups as $row) {
            echo '<tr>';
            echo '<td><input name="checked_groups[]" type="checkbox" value="'.$row['group_id'].'" /></td>';
            echo '<td>'.$row['group_id'].'</td>';
            echo '<td>'.RHtmlHelper::linkAction('user',$row['creator_name'],'view',$row['group_creator_id']).'</td>';
            echo '<td>'.RHtmlHelper::linkAction('category',$row['category_name'],'groups',$row['group_category_id']).'</td>';
            echo '<td>'.RHtmlHelper::linkAction('group', $row['group_name'], 'detail', $row['group_id']).'</td>';
            echo '<td>'.$row['group_member_count'].'</td>';
            echo '<td>'.$row['group_created_time'].'</td>';
            if(isset($row['group_picture'])&&$row['group_picture']!='')
                echo '<td>'.RHtmlHelper::showImage($row['group_picture'],$row['group_name'],array("style"=>'width:64px;')).'</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?=RFormHelper::endForm()?>

<?= (isset($pager) ? $pager : '') ?>
