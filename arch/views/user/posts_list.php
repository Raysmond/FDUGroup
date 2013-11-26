<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-11-26
 * Time: 下午3:10
 */
?>
<?php
foreach ($topics as $topic) {
    ?>
    <div class="row topic-item">
        <div class="col-lg-2 topic-picture">
            <?php
            if ($topic['u_picture'] == '') {
                $topic['u_picture'] = User::$defaults['picture'];
            }
            $thumbnail = RImageHelper::styleSrc($topic['u_picture'],User::getPicOptions());
            ?>
            <?= RHtmlHelper::showImage($thumbnail, $topic['u_name'], array('width' => '64px')) ?>

        </div>
        <div class="col-lg-10 topic-content">
            <div><?= RHtmlHelper::linkAction('post', $topic['top_title'], 'view', $topic['top_id']) ?></div>
            <div class="topic-meta">
                <?= RHtmlHelper::linkAction('user', $topic['u_name'], 'view', $topic['u_id']) ?>
                post
                in <?= RHtmlHelper::linkAction('group', $topic['gro_name'], 'detail', $topic['gro_id']) ?>
                &nbsp;&nbsp;<?= $topic['top_created_time'] ?>
            </div>
            <div>
                <?php
                $topic['top_content'] = strip_tags(RHtmlHelper::decode($topic['top_content']));
                if (mb_strlen($topic['top_content']) > 140) {
                    echo '<p>' . mb_substr($topic['top_content'], 0, 140, 'UTF-8') . '...</p>';
                } else echo '<p>' . $topic['top_content'] . '</p>';
                ?>
            </div>

            <div>
                <?= RHtmlHelper::linkAction(
                    'post',
                    'Reply(' . $topic['top_comment_count'] . ')',
                    'view', $topic['top_id'] . '#reply',
                    array('class'=>'btn btn-xs btn-info')) ?>
                <?php
                $this->module("rating_plus",
                    array(
                        'id'=>'rating_plus',
                        'entityType'=>Topic::$entityType,
                        'entityId'=>$topic['top_id'],
                        'count'=>$topic['plusCount'],
                        'buttonClass'=>'btn btn-info btn-xs'
                    ));
                ?>
            </div>

        </div>
    </div>
    <hr>
<?php
}
?>