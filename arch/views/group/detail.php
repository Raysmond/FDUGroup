<?php
/**
 * Group detail page
 * @author: Raysmond
 */
?>
<h2>
    <?= $group->name ?>&nbsp;&nbsp;
    <?php
    if (!$hasJoined)
        echo RHtmlHelper::linkAction('group', '+ Join the group', 'join', $group->id, array('class' => 'btn btn-xs btn-info'));
    else if ($isManager){
        echo RHtmlHelper::linkAction('group', 'Manager: Edit group', 'edit', $group->id, array('class' => 'btn btn-xs btn-info'));
        echo '&nbsp;&nbsp;';echo RHtmlHelper::linkAction('group', 'Manager: Delete group', 'delete', $group->id, array('class' => 'btn btn-xs btn-danger'));
    }
    else echo RHtmlHelper::linkAction('group', '- Exit group', 'exit', $group->id, array('class' => 'btn btn-xs btn-info'));
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
                Group introduction: <p><?php echo RHtmlHelper::decode($group->intro); ?></p> <br/>
            </div>
        </div>
    </div>
</div>

<!-- Latest posts -->
<div>
    <div class="row">
        <div class="col-sm-6">
        <h3 style="margin: 10px 0;">Latest Posts</h3>
            </div>
        <div class="col-sm-3" style="float:right;text-align: right;">
        <?php if($hasJoined) echo RHtmlHelper::linkAction('post',"Add new post",'new',$group->id,
            array('class'=>'btn btn-xs btn-success','style'=>'margin: 10px 0;')) ?>
        </div>
    </div>
    <?php if (count($latestPosts) > 0): ?>
        <table class="table table-hover table-condensed">
            <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Replies</th>
                <th>Time</th>
                <th>Last comment</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($latestPosts as $topic) {
                ?>
                <tr>
                <td><b><?= RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id) ?></b></td>
                <td><?= RHtmlHelper::linkAction('user', $topic->user->name, 'view', $topic->user->id) ?></td>
                <td><?= $topic->commentCount ?></td>
                <td><?= $topic->createdTime ?></td>
                <td><?= $topic->lastCommentTime ?></td></tr><?php
            }
            ?>
            </tbody>
        </table>
        <ul class="pager">
            <li class="next"><a href="<?= RHtmlHelper::siteUrl('post/list/' . $group->id) ?>">More topics &rarr;</a>
            </li>
        </ul>
    <?php endif; ?>
    <?=(count($latestPosts)==0)?"No posts.":""?>
</div>