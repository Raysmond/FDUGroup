<?php if(!empty($posts)): ?>
<div class="posts-list">
    <div id="latest-topics-list">
        <?php
        $user = Rays::user();
        if ($user->picture == '') {
            $user->picture = User::$defaults['picture'];
        }
        foreach ($posts as $post) {
            ?>
            <div class="row topic-item">
                <div class="col-lg-2 topic-picture">
                    <?= RHtml::showImage(RImage::styleSrc($user->picture, User::getPicOptions()), $user->name, array('width' => '64px')) ?>
                </div>
                <div class="col-lg-10 topic-content">
                    <span class="arrow"></span>
                    <div class="inner">
                        <div class="topic-title">
                            <?= RHtml::linkAction('post', $post->title, 'view', $post->id) ?>
                        </div>
                        <div class="topic-meta">
                            <?= RHtml::linkAction('view', $user->name, 'view', $user->id) ?>
                            <?= $post->createdTime ?>
                        </div>
                        <div class="topic-summary">
                            <?php
                            $post->content = (RHtml::decode($post->content));
                            $content = strip_tags($post->content);
                            if (mb_strlen($content) > 140) {
                                echo '<p>' . mb_substr($content, 0, 140, 'UTF-8') . '...</p>';
                            } else echo '<p>' . $content . '</p>';

                            preg_match_all("/<img[^>]+>/i",$post->content,$matches);
                            if(!empty($matches)){
                                foreach($matches as $src){
                                    if(!empty($src)){
                                        echo $src[0];
                                    }
                                }
                            }
                            ?>

                        </div>
                    </div>

                    <div class="footer">
                        <div class="actions">
                            <a href="<?=RHtml::siteUrl('post/view/'.$post->id).'#reply'?>">
                                <span class="glyphicon glyphicon-comment"></span> <?=$post->commentCount?>
                            </a>

                            &nbsp;
                            <?php
                            $self->module("rating_plus",
                                array(
                                    'id'=>'rating_plus',
                                    'entityType'=>Topic::ENTITY_TYPE,
                                    'entityId'=>$post->id,
                                ));
                            ?>

                            &nbsp;
                            <a href="<?=RHtml::siteUrl('post/delete/'.$post->id)?>">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>

                        </div>
                    </div>


                </div>
            </div>
            <hr>
        <?php } ?>

        <?= (isset($pager))?$pager:"" ?>
    </div>
</div>
<?php endif; ?>

<?php if(empty($posts)): ?>
    <div class="panel panel-default">
        <div class="panel-body">
            You have no posts.
        </div>
    </div>
<?php endif; ?>