<?php
/**
 * View file.
 * Groups in a category
 * @author: Raysmond
 */

?>
<h2>All Groups in <?php echo $category->name; ?></h2>

<?php

$count = 0;
foreach($groups as $group){
    if($count==0){
        echo '<div class="row">';
    }

    echo '<div class="col-6 col-sm-6 col-lg-4" style="height: 190px;">';
    echo "<div class='panel panel-default' style='height: 170px;'>";
    echo "<div class='panel-heading'>";
    echo RHtmlHelper::linkAction('group',$group->name,'detail',$group->id);
    echo "</div>";
    echo "<div class='panel-body'>";
    echo $group->memberCount." members";
    $group->intro = strip_tags(RHtmlHelper::decode($group->intro));
    if (mb_strlen($group->intro) > 70) {
        echo '<p>' . mb_substr($group->intro, 0, 70,'UTF-8') . '...</p>';
    } else echo '<p>' . $group->intro . '</p>';

    echo RHtmlHelper::linkAction('group','Join the group','join',$group->id,
        array('class'=>'btn btn-xs btn-info','style'=>'position:absolute;top:135px;'));
    echo "</div></div></div>";

    $count++;
    if(($count==3)){
        echo '</div>';
        $count = 0;
    }
}
if($count!=0)
    echo "</div>";

