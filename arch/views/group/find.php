<?php
/**
 * show all groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:52
 */
    foreach($data as $group){
        echo '<div class="jumbotron">';
        foreach($group->columns as $col=>$coldb){
            if(isset($group->$col))
                echo $group->$col.'      s';
        }
        $data = null;
        echo RFormHelper::button($data,'apply');
        echo '</div>';
    }