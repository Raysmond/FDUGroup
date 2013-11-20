<h1>Active topics</h1>
<div>
    <?= RHtmlHelper::linkAction('post', 'All', 'public', null, array('class' => 'btn btn-sm btn-success')) ?>
    <?= RHtmlHelper::linkAction('post', 'Today', 'public', 'day', array('class' => 'btn btn-sm btn-success')) ?>
    <?= RHtmlHelper::linkAction('post', 'This week', 'public', 'week', array('class' => 'btn btn-sm btn-success')) ?>
    <?= RHtmlHelper::linkAction('post', 'This month', 'public', 'month', array('class' => 'btn btn-sm btn-success')) ?>
    <br/><br/>
</div>
<div id="active-topics-list">
    <?php
    foreach ($topics as $topic) {
        ?>
        <div class="row topic-item">
            <div class="col-lg-1 topic-picture">
                <?php if ($topic['user_picture'] == '') {
                    $topic['user_picture'] = User::$defaults['user_picture'];
                }?>
                <?= RHtmlHelper::showImage($topic['user_picture'], $topic['user_name'], array('width' => '64px')) ?>

            </div>
            <div class="col-lg-11 topic-content">
                <div><?= RHtmlHelper::linkAction('post', $topic['topic_title'], 'view', $topic['topic_id']) ?></div>
                <div class="topic-meta">
                    <?= RHtmlHelper::linkAction('user', $topic['user_name'], 'view', $topic['user_id']) ?>
                    post in <?= RHtmlHelper::linkAction('group', $topic['group_name'], 'detail', $topic['group_id']) ?>
                    &nbsp;&nbsp;<?= $topic['topic_created_time'] ?>
                </div>
                <div>
                    <?php
                    $topic['topic_content'] = strip_tags(RHtmlHelper::decode($topic['topic_content']));
                    if (mb_strlen($topic['topic_content']) > 140) {
                        echo '<p>' . mb_substr($topic['topic_content'], 0, 140, 'UTF-8') . '...</p>';
                    } else echo '<p>' . $topic['topic_content'] . '</p>';
                    ?>
                </div>

                <div>
                    <?= RHtmlHelper::linkAction('post', 'Reply(' . $topic['topic_comment_count'] . ')', 'view', $topic['topic_id'] . '#reply') ?>
                </div>

            </div>
        </div>
        <hr>
    <?php
    }
    ?>
</div><!--END last-topics-list-->