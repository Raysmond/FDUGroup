<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        Comments
        <div class="navbar-right">
        </div>
    </div>
    <table id="admin-comments" class="table">
        <thead>
        <tr>
            <?php
            $skips = array("intro");
            echo '<th><input id="check-all" name="check-all" onclick="javascript:checkReverse(\'checked_comments[]\')" type="checkbox" /></th>';
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

        foreach ($comments as $row) {
            echo '<tr>';
            foreach($row as $objCol=>$dbCol){
                echo '<td>';
                echo $row->$objCol;
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>

<?= (isset($pager) ? $pager : '') ?>
