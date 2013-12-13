<?php
/**
 * Posts list view file.
 * This view file only render the posts list. It's useful for partial rendering without the layout,
 * for example: render the result for an Ajax request
 *
 * @author: Raysmond
 */
?>
<?php if(!empty($topics)): ?>
<div class="posts-list">
    <?php
    $currentUserId = Rays::isLogin()?Rays::user()->id:0;
    foreach ($topics as $topic) {
        ?>
        <div class="row topic-item">
            <!-- User picture -->
            <div class="col-lg-2 topic-picture">
                <?php
                if ($topic->user->picture == '') {
                    $topic->user->picture = User::$defaults['picture'];
                }
                $thumbnail = RImageHelper::styleSrc($topic->user->picture, User::getPicOptions());
                ?>
                <a href="<?=RHtmlHelper::siteUrl("user/view/".$topic->user->id)?>" title="<?=$topic->user->name?>">
                    <?= RHtmlHelper::showImage($thumbnail, $topic->user->name, array('width' => '64px')) ?>
                </a>

            </div>


            <div class="col-lg-10 topic-content">
                <span class="arrow"></span>
                <div class="inner">
                    <div class="topic-title"><?= RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id) ?></div>

                    <!-- Topic meta info -->
                    <div class="topic-meta">
                        <?= RHtmlHelper::linkAction('user', $topic->user->name, 'view', $topic->user->id) ?>
                        post
                        in <?= RHtmlHelper::linkAction('group', $topic->group->name, 'detail', $topic->group->id) ?>

                    </div>

                    <!-- Topic summary -->
                    <div>
                        <?php
                        $topic->content = (RHtmlHelper::decode($topic->content));
                        $content = strip_tags($topic->content);
                        if (mb_strlen($content) > 140) {
                            echo '<p>' . mb_substr($content, 0, 140, 'UTF-8') . '...</p>';
                        } else {
                            echo '<p>' . $content . '</p>';
                        }
                        preg_match_all("/<img[^>]+>/i",$topic->content,$matches);
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
                    <?php
//                    $now = new DateTime();
//                    $time = new DateTime($topic['top_created_time']);
//                    $interval = $now->diff($time);

                    ?>
                    <?= $topic->createdTime ?>

                    <div class="actions">
                        <a href="<?=RHtmlHelper::siteUrl('post/view/'.$topic->id).'#reply'?>">
                            <span class="glyphicon glyphicon-comment"></span> <?=$topic->commentCount?>
                        </a>
                        <?php

                        if(isset($enabledDelete)&&$enabledDelete){
                            if($currentUserId!==0&&$topic->user->id==$currentUserId){
                                echo '&nbsp;';
                                echo RHtmlHelper::linkAction(
                                    'post',
                                    'Delete',
                                    'delete', $topic->id,
                                    array('class' => 'btn btn-xs btn-danger'));
                            }
                        }
                        echo '&nbsp;';
                        $this->module("rating_plus",
                            array(
                                'id' => 'rating_plus',
                                'entityType' => Topic::ENTITY_TYPE,
                                'entityId' => $topic->id,
//                                'count' => $topic['plusCount']
                            ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="i"></div>
        </div>
        <hr>
    <?php
    }
    ?>
</div>
<?php endif; ?>
<!--END last-topics-list-->
