<div class="comments-list">
    <?php
    foreach ($commentTree as $commentItem) {
        ?>
        <div id="comment-item-<?= $commentItem['root']->id ?>" class="row comment-item">

            <!-- user picture -->
            <div class="col-lg-2 user-picture">
                <?php
                $picture = $commentItem['root']->user->picture;
                if(!isset($picture) || $picture==''){
                    $picture = User::$defaults['picture'];
                }
                $src = RImageHelper::styleSrc($picture,User::getPicOptions());
                ?>
                <?= RHtmlHelper::showImage($src, $commentItem['root']->user->name, array('width' => '64px;')) ?>
            </div>

            <!-- comment content -->
            <div class="col-lg-10 comment-content">

                <div class="comment-meta">
                    <?= RHtmlHelper::linkAction('user', $commentItem['root']->user->name, 'view', $commentItem['root']->user->id) ?>
                    &nbsp;&nbsp;
                    <?= $commentItem['root']->createdTime ?>
                </div>

                <div class="comment-body"><?= RHtmlHelper::decode($commentItem['root']->content) ?></div>

                <div class="comment-actions">
                    <?=
                    RHtmlHelper::linkAction('post', 'Reply', 'view',
                        $commentItem['root']->topicId . '?reply=' . $commentItem['root']->id . '#reply',
                        array('class' => 'btn btn-xs btn-info')) ?>
                </div>

                <div class="comment-reply-list">
                    <?php
                    foreach ($commentItem['reply'] as $reply) {
                        ?>
                        <div class="comment-reply-item">
                            <?= RHtmlHelper::linkAction('user', $reply->user->name, 'view', $reply->user->id) ?>
                            &nbsp;&nbsp;<?= $reply->createdTime ?>
                        </div>

                        <div><?= RHtmlHelper::decode($reply->content) ?></div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <hr>
    <?php
    }
    ?>
</div>