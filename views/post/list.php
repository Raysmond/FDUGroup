<div class="panel panel-default">
    <div class="panel-heading"><h1 class="panel-title"><?=$group->name?></h1></div>

    <div class="panel-body">
        <div class="row">
            <?=RHtml::linkAction('group','Back to group','detail',$group->id,array('class'=>'btn btn-sm btn-info'))?>
            <div style="float: right;">
                <?php
                    if($canPost)
                        echo RHtml::linkAction('post', '+ New post', 'new', $group->id, array('class' => 'btn btn-sm btn-success'));
                ?>
            </div>
        </div>

        <hr>

        <div class="row">
            <?php
                $self->renderPartial("_common._posts_table", array('posts'=>$topics,'showAuthor'=>true),false);
            ?>
            <?=isset($pager)?$pager:""?>
        </div>
    </div>

</div>