<?php
/**
 * Posts list view file.
 * This view file only render the posts list. It's useful for partial rendering without the layout,
 * for example: render the result for an Ajax request
 *
 * @author: Raysmond
 */
?>
<div class="posts-list">
    <?php
    $currentUserId = Rays::app()->isUserLogin()?Rays::app()->getLoginUser()->id:0;
    foreach ($topics as $topic) {
        ?>
        <div class="row topic-item">
            <!-- User picture -->
            <div class="col-lg-2 topic-picture">
                <?php
                if ($topic['u_picture'] == '') {
                    $topic['u_picture'] = User::$defaults['picture'];
                }
                $thumbnail = RImageHelper::styleSrc($topic['u_picture'], User::getPicOptions());
                ?>
                <a href="<?=RHtmlHelper::siteUrl("user/view/".$topic['u_id'])?>" title="<?=$topic['u_name']?>">
                    <?= RHtmlHelper::showImage($thumbnail, $topic['u_name'], array('width' => '64px')) ?>
                </a>

            </div>

            <div class="col-lg-10 topic-content">
                <div class="inner">
                    <div class="topic-title"><?= RHtmlHelper::linkAction('post', $topic['top_title'], 'view', $topic['top_id']) ?></div>

                    <!-- Topic meta info -->
                    <div class="topic-meta">
                        <?= RHtmlHelper::linkAction('user', $topic['u_name'], 'view', $topic['u_id']) ?>
                        post
                        in <?= RHtmlHelper::linkAction('group', $topic['gro_name'], 'detail', $topic['gro_id']) ?>

                    </div>

                    <!-- Topic summary -->
                    <div>
                        <?php
                        $topic['top_content'] = (RHtmlHelper::decode($topic['top_content']));
                        $content = strip_tags($topic['top_content']);
                        if (mb_strlen($content) > 140) {
                            echo '<p>' . mb_substr($content, 0, 140, 'UTF-8') . '...</p>';
                        } else {
                            echo '<p>' . $content . '</p>';
                        }
                        preg_match_all("/<img[^>]+>/i",$topic['top_content'],$matches);
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
                    <?= $topic['top_created_time'] ?>

                    <div class="actions">
                        <a href="<?=RHtmlHelper::siteUrl('post/view/'.$topic['top_id']).'#reply'?>">
                            <span class="glyphicon glyphicon-comment"></span> <?=$topic['top_comment_count']?>
                        </a>
                        <?php

                        if(isset($enabledDelete)&&$enabledDelete){
                            if($currentUserId!==0&&$topic['u_id']==$currentUserId){
                                echo '&nbsp;';
                                echo RHtmlHelper::linkAction(
                                    'post',
                                    'Delete',
                                    'delete', $topic['top_id'],
                                    array('class' => 'btn btn-xs btn-danger'));
                            }
                        }
                        echo '&nbsp;';
                        $this->module("rating_plus",
                            array(
                                'id' => 'rating_plus',
                                'entityType' => Topic::$entityType,
                                'entityId' => $topic['top_id'],
                                'count' => $topic['plusCount']
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
<!--END last-topics-list-->