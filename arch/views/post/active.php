<h1>Active topics</h1>
<div>
    <?= RHtmlHelper::linkAction('post', 'All', 'active', null, array('class' => 'btn btn-sm btn-success')) ?>
    <?= RHtmlHelper::linkAction('post', 'Today', 'active', 'day', array('class' => 'btn btn-sm btn-success')) ?>
    <?= RHtmlHelper::linkAction('post', 'This week', 'active', 'week', array('class' => 'btn btn-sm btn-success')) ?>
    <?= RHtmlHelper::linkAction('post', 'This month', 'active', 'month', array('class' => 'btn btn-sm btn-success')) ?>
    <br/><br/>
</div>
<div id="active-topics-list">
    <?php
    foreach ($topics as $topic) {
        ?>
        <div class="row topic-item">
            <div class="col-lg-1 topic-picture">
                <?php if ($topic->user->picture == '') {
                    $topic->user->picture = User::$defaults['user_picture'];
                }?>
                <?= RHtmlHelper::showImage($topic->user->picture, $topic->user->name, array('width' => '64px')) ?>

            </div>
            <div class="col-lg-11 topic-content">
                <div><?= RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id) ?></div>
                <div class="topic-meta">
                    <?= RHtmlHelper::linkAction('user', $topic->user->name, 'view', $topic->user->id) ?>
                    post in <?= RHtmlHelper::linkAction('group', $topic->group->name, 'detail', $topic->group->id) ?>
                    &nbsp;&nbsp;<?= $topic->createdTime ?>
                </div>
                <div>
                    <?php
                    $topic->content = strip_tags(RHtmlHelper::decode($topic->content));
                    if (mb_strlen($topic->content) > 140) {
                        echo '<p>' . mb_substr($topic->content, 0, 140, 'UTF-8') . '...</p>';
                    } else echo '<p>' . $topic->content . '</p>';
                    ?>
                </div>

                <div>
                    <?= RHtmlHelper::linkAction('post', 'Reply(' . $topic->commentCount . ')', 'view', $topic->id . '#reply') ?>
                </div>

            </div>
        </div>
        <hr>
    <?php
    }
    ?>
</div><!--END last-topics-list-->