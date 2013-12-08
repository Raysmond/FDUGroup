<?php if(!empty($posts)): ?>
<div class="posts-list">
    <div id="latest-topics-list">
        <?php
        $user = Rays::app()->getLoginUser();
        if ($user->picture == '') {
            $user->picture = User::$defaults['picture'];
        }
        foreach ($posts as $post) {
            ?>
            <div class="row topic-item">
                <div class="col-lg-2 topic-picture">
                    <?= RHtmlHelper::showImage(RImageHelper::styleSrc($user->picture, User::getPicOptions()), $user->name, array('width' => '64px')) ?>
                </div>
                <div class="col-lg-10 topic-content">
                    <span class="arrow"></span>
                    <div class="inner">
                        <div class="topic-title">
                            <?= RHtmlHelper::linkAction('post', $post->title, 'view', $post->id) ?>
                        </div>
                        <div class="topic-meta">
                            <?= RHtmlHelper::linkAction('view', $user->name, 'view', $user->id) ?>
                            <?= $post->createdTime ?>
                        </div>
                        <div class="topic-summary">
                            <?php
                            $post->content = (RHtmlHelper::decode($post->content));
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
                            <a href="<?=RHtmlHelper::siteUrl('post/view/'.$post->id).'#reply'?>">
                                <span class="glyphicon glyphicon-comment"></span> <?=$post->commentCount?>
                            </a>

                            &nbsp;
                            <?php
                            $this->module("rating_plus",
                                array(
                                    'id'=>'rating_plus',
                                    'entityType'=>Topic::$entityType,
                                    'entityId'=>$post->id,
                                ));
                            ?>

                            &nbsp;
                            <a href="<?=RHtmlHelper::siteUrl('post/delete/'.$post->id)?>">
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