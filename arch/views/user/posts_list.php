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
                <?= RHtmlHelper::showImage($thumbnail, $topic['u_name'], array('width' => '64px')) ?>
            </div>

            <div class="col-lg-10 topic-content">
                <div><?= RHtmlHelper::linkAction('post', $topic['top_title'], 'view', $topic['top_id']) ?></div>

                <!-- Topic meta info -->
                <div class="topic-meta">
                    <?= RHtmlHelper::linkAction('user', $topic['u_name'], 'view', $topic['u_id']) ?>
                    post
                    in <?= RHtmlHelper::linkAction('group', $topic['gro_name'], 'detail', $topic['gro_id']) ?>
                    &nbsp;&nbsp;<?= $topic['top_created_time'] ?>
                </div>

                <!-- Topic summary -->
                <div>
                    <?php
                    $topic['top_content'] = strip_tags(RHtmlHelper::decode($topic['top_content']));
                    if (mb_strlen($topic['top_content']) > 140) {
                        echo '<p>' . mb_substr($topic['top_content'], 0, 140, 'UTF-8') . '...</p>';
                    } else echo '<p>' . $topic['top_content'] . '</p>';
                    ?>
                </div>

                <!-- Actions for the post -->
                <div>
                    <?=
                    RHtmlHelper::linkAction(
                        'post',
                        'Reply(' . $topic['top_comment_count'] . ')',
                        'view', $topic['top_id'] . '#reply',
                        array('class' => 'btn btn-xs btn-info')) ?>

                    <?php
                    $this->module("rating_plus",
                        array(
                            'id' => 'rating_plus',
                            'entityType' => Topic::$entityType,
                            'entityId' => $topic['top_id'],
                            'count' => $topic['plusCount'],
                            'buttonClass' => 'btn btn-info btn-xs'
                        ));
                    ?>
                </div>

            </div>
        </div>
        <hr>
    <?php
    }
    ?>
</div>
<!--END last-topics-list-->