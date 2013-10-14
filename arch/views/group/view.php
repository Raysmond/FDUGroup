<?php
/**
 * show my groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:53
 */
    if($data == null){
        echo "<p>You have not joint any groups!</p>";
        return null;
    }
    foreach($data as $group){
        echo '<div class="jumbotron">';
        foreach($group->columns as $col=>$coldb){
            if(isset($group->$col))
                echo $group->$col.'      s';
        }
        $data = null;
        echo RFormHelper::button($data,'Exit');
        echo '</div>';
    }