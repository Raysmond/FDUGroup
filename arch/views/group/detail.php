<?php
/**
 * Group detail page
 * @author: Raysmond
 */
?>
<h2>
    <?php
    echo $group->name.'&nbsp&nbsp&nbsp';
    if(Rays::app()->isUserLogin()){
        $g_u = new GroupUser();
        $g_u->userId = Rays::app()->getLoginUser()->id;
        $g_u->groupId = $group->id;
        $g_u = $g_u->find();
        if(count($g_u)==0){
            echo RHtmlHelper::linkAction('group','+ Join the group','join',$group->id,array('class'=>'btn btn-xs btn-info'));
        }else{
            if($group->creator == Rays::app()->getLoginUser()->id){
                echo RHtmlHelper::linkAction('group','Manager: Edit group','edit',$group->id,array('class'=>'btn btn-xs btn-info'));
            }else
                echo RHtmlHelper::linkAction('group','- Exit group','exit',$group->id,array('class'=>'btn btn-xs btn-info'));
        }
    }else{
        echo RHtmlHelper::linkAction('group','+ Join the group','join',$group->id,array('class'=>'btn btn-xs btn-info'));
    }
    //echo RHtmlHelper::linkAction('group','Join group','detail',null,array('class'=>'btn btn-success'));
    ?>
</h2>
<div class="jumbotron">
<p><h4>
    create time:<?php echo $group->createdTime; ?> &nbsp &nbsp
    created by: <?php echo RHtmlHelper::linkAction('user',$group->groupCreator->name,'view',$group->creator) ?> &nbsp &nbsp
    group type: <?php echo RHtmlHelper::linkAction('category',$group->category->name,'view',$group->category->id); ?> <br/>
    Group members: <?php echo $group->memberCount; ?> <br/>
    <br/>Group introduction: <?php echo $group->intro; ?> <br/>
</h4></p>
</div>