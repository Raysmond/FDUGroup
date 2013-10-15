<?php
/**
 * Group detail page
 * @author: Raysmond
 */
?>
<h2>
    <?php
    echo $group->name . '&nbsp&nbsp&nbsp';
    if (Rays::app()->isUserLogin()) {
        $g_u = new GroupUser();
        $g_u->userId = Rays::app()->getLoginUser()->id;
        $g_u->groupId = $group->id;
        $g_u = $g_u->find();
        if (count($g_u) == 0) {
            echo RHtmlHelper::linkAction('group', '+ Join the group', 'join', $group->id, array('class' => 'btn btn-xs btn-info'));
        } else {
            if ($group->creator == Rays::app()->getLoginUser()->id) {
                echo RHtmlHelper::linkAction('group', 'Manager: Edit group', 'edit', $group->id, array('class' => 'btn btn-xs btn-info'));
            } else
                echo RHtmlHelper::linkAction('group', '- Exit group', 'exit', $group->id, array('class' => 'btn btn-xs btn-info'));
        }
    } else {
        echo RHtmlHelper::linkAction('group', '+ Join the group', 'join', $group->id, array('class' => 'btn btn-xs btn-info'));
    }
    //echo RHtmlHelper::linkAction('group','Join group','detail',null,array('class'=>'btn btn-success'));
    ?>
</h2>
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">

            <?php
            if (isset($group->picture) && $group->picture != '') {
                echo '<div class="col-xs-3">';
                echo RHtmlHelper::showImage($group->picture, $group->name,
                    array('class' => 'img-thumbnail', 'style' => 'width:200px;'));
                echo '</div>';
            }
            ?>

            <div class="col-xs-9">
                Group members: <?php echo $group->memberCount; ?> <br/>
                Create time: <?php echo $group->createdTime; ?> <br/>
                Created by: <?php echo RHtmlHelper::linkAction('user',
                    $group->groupCreator->name, 'view', $group->creator) ?>
                <br/>
                Group category: <?php echo RHtmlHelper::linkAction('category',
                    $group->category->name, 'groups', $group->category->id); ?>
                <br/>

                <br/>
                Group introduction: <p><?php echo $group->intro; ?></p> <br/>
            </div>
        </div>
    </div>
</div>