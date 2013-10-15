<?php
/**
 * show my groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:53
 */

    echo RHtmlHelper::linkAction('group','Build my group','build',null,array('class'=>'btn btn-success'));

    echo "<br/><br/>";

    if($data == null){
        echo "<p>You have not joint any groups!</p>";
        return null;
    }

$count = 0;
foreach($data as $group){
    if($count==0){
        echo '<div class="row">';
    }

    echo '<div class="col-6 col-sm-6 col-lg-4" style="height: 190px;">';
    echo "<div class='panel panel-default' style='height: 170px;'>";
    echo "<div class='panel-heading'>";
    if(isset($group->picture)&&$group->picture!=''){
        //echo RHtmlHelper::showImage($group->picture,$group->name,array('style'=>'height:32px;'));
    }
    echo RHtmlHelper::linkAction('group',$group->name,'detail',$group->id);
    echo "</div>";

    echo "<div class='panel-body'>";
    echo $group->memberCount." members";
    if(strlen($group->intro)>100){
        echo '<p>'.substr($group->intro,0,100).'...</p>';
    }
    else echo '<p>'.$group->intro.'</p>';
    echo RHtmlHelper::linkAction('group','Exit group','exit',$group->id,
        array('class'=>'btn btn-xs btn-info','style'=>'position:absolute;top:135px;right:120px;'));

    echo RHtmlHelper::linkAction('group','View details','detail',$group->id
    ,array('class'=>'btn btn-xs btn-info','style'=>'position:absolute;top:135px;right:30px;'));

    echo "</div></div>";
    echo "</div>";

    $count++;
    if(($count==3)){
        echo '</div>';
        $count = 0;
    }
}
if($count!=0)
    echo "</div>";

