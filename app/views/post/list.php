<div class="panel panel-default">
    <div class="panel-heading"><h1 class="panel-title"><?=$group->name?></h1></div>

    <div class="panel-body">
        <div class="row">
            <?=RHtmlHelper::linkAction('group','Back to group','detail',$group->id,array('class'=>'btn btn-sm btn-info'))?>
            <div style="float: right;">
                <?=RHtmlHelper::linkAction('post', '+ New topic', 'new', $group->id, array('class' => 'btn btn-sm btn-success'))?>
            </div>
        </div>

        <hr>

        <div class="row">
            <?php
            if($topics===null){
                echo '<p>No topics!</p>';
            }
            ?>

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
    </div>

</div>