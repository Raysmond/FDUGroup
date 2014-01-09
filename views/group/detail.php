<?php
/**
 * Group detail page
 * @author: Raysmond
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="heading-actions" style="float: right;">
            <?php
                if($isManager || (Rays::isLogin()&&Rays::user()->isAdmin())){
                    echo RHtml::linkAction('group',"Edit",'edit',$group->id,array('class'=>'btn btn-xs btn-success'));
                    echo '&nbsp;';
                    echo RHtml::linkAction('group',"Invite",'invite',$group->id,array('class'=>'btn btn-xs btn-info'));
                    echo '&nbsp;';
                }
                if(!$hasJoined){
                    echo RHtml::linkAction('group','Join','join',$group->id,array('class'=>'btn btn-xs btn-success'));
                    echo '&nbsp;';
                }
                else{
                    echo RHtml::linkAction('group','Quit','exit',$group->id,array('class'=>'btn btn-xs btn-danger','onclick'=>'return confirm(\'Are you sure to quit the group? This operation cannot be undone!\')'));
                }
            ?>
        </div>
        <h1 class="panel-title"><?= $group->name ?></h1>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php
            if (isset($group->picture) && $group->picture != '') {
                echo '<div class="col-xs-3 group-picture">';
                $picture = RImage::styleSrc($group->picture, Group::getPicOptions());
                echo RHtml::image($picture, $group->name,
                    array('class' => 'img-thumbnail', 'style' => 'width:200px;'));
                echo '</div>';
            }
            ?>

            <div class="group-content col-xs-9">
                <div class="group-meta">
                    <span
                        class="glyphicon glyphicon-tag"></span> <?= RHtml::linkAction('category', $group->category->name, 'groups', $group->category->id); ?>
                    &nbsp;
                    <span class="glyphicon glyphicon-user"></span> <?= $group->memberCount ?>
                    &nbsp;
                    <span class="glyphicon glyphicon-search"></span> <?= $counter ?>
                    &nbsp;
                    <?= RHtml::linkAction('user', $group->groupCreator->name, 'view', $group->creator) ?>
                    created at
                    <?= $group->createdTime ?>

                </div>

                <div class="group-intro"><?php echo RHtml::decode($group->intro); ?></div>
            </div>
        </div>


        <hr>

        <!-- Latest posts -->
        <div class="row group-posts">
            <div class="col-sm-6">
                <h2 class="s-title">Latest Posts</h2>
            </div>
            <div class="col-sm-3" style="float:right;text-align: right;padding-right:0;">
                <?php if ($hasJoined) echo RHtml::linkAction('post', "Add new post", 'new', $group->id,
                    array('class' => 'btn btn-xs btn-success', 'style' => 'margin: 10px 0;')) ?>
            </div>

            <div class="clearfix"></div>
            <div>
                <?php
                $self->renderPartial("_common._posts_table", array('posts'=>$latestPosts,'showAuthor'=>true),false);
                if(!empty($latestPosts)){
                    ?>
                    <ul class="pager">
                        <li class="next"><a href="<?= RHtml::siteUrl('post/list/' . $group->id) ?>">More topics &rarr;</a>
                        </li>
                    </ul>
                <?php
                }
                ?>

            </div>

        </div>
    </div>

</div>