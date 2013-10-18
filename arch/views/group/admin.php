<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 */
?>

<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        Users
        <div class="navbar-right">
            <a class="btn btn-sm btn-danger" title="Delete" href="#">Delete</a>
        </div>
    </div>

    <!-- Table -->
    <table id="admin-users" class="table">
        <thead>
        <tr>
            <?php
            $skips = array("intro");
            echo '<th><input id="check-all" name="check-all" onclick="#" type="checkbox" /></th>';
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
            echo '<td><input name="checked_users" type="checkbox" /></td>';
            foreach ($row->columns as $objCol => $dbcol) {
                if (in_array($objCol, $skips)) continue;
                echo '<td>';
                switch ($objCol) {
                    case "categoryId":
                        $cat = new Category();$cat->load($row->$objCol);
                        echo RHtmlHelper::linkAction('category',$cat->name,'groups',$cat->id);
                        break;
                    case "name":
                        echo RHtmlHelper::linkAction('group', $row->$objCol, 'detail', $row->id);
                        break;
                    case "creator":
                        $user = new User();$user->load($row->$objCol);
                        echo RHtmlHelper::linkAction('user',$user->name,'view',$user->id);
                        break;
                    case "picture":
                        if(isset($row->picture)&&$row->picture!='')
                            echo RHtmlHelper::showImage($row->picture,$row->name,array("style"=>'width:64px;'));
                        break;
                    default:
                        echo $row->$objCol;
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
