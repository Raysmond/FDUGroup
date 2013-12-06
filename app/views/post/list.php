<div class="panel panel-wrapper">

    <?=RHtmlHelper::linkAction('post', '+ New topic', 'new', $group->id, array('class' => 'btn btn-success'))?>
    <br/><br/>
    <?php
    if ($topics == null) {
        ?><p>No topics.</p><?php
        return null;
    }

    ?>
    <h1>
        <?=$group->name?>
        <?=RHtmlHelper::linkAction('group','Back to group','detail',$group->id,array('class'=>'btn btn-xs btn-info'))?>
    </h1>
    <table class="table table-hover table-condensed">
        <thead><tr><th>Title</th><th>Replies</th><th>Time</th><th>Last comment</th></tr></thead>
        <tbody><?php

        foreach ($topics as $topic) {
            ?><tr><td><b><?=RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id)?></b></td>
            <td><?=$topic->commentCount?></td>
            <td><?=$topic->createdTime?></td>
            <td><?=$topic->lastCommentTime?></td></tr><?php
        }

        ?></tbody></table>

</div>