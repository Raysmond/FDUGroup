<div class="panel panel-default row">
    <div class="panel-heading">
        <b>My posts (<?=$count?>)</b>
    </div>
    <div class="panel-body" id="latest-topics-list">
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
                    <div class="topic-title">
                        <?= RHtmlHelper::linkAction('post', $post->title, 'view', $post->id) ?>
                    </div>
                    <div class="topic-meta">
                        <?= RHtmlHelper::linkAction('view', $user->name, 'view', $user->id) ?>
                        <?= $post->createdTime ?>
                    </div>
                    <div class="topic-summary">
                        <?php
                        $post->title = strip_tags(RHtmlHelper::decode($post->title));
                        if (mb_strlen($post->title) > 140) {
                            echo '<p>' . mb_substr($post->title, 0, 140, 'UTF-8') . '...</p>';
                        } else echo '<p>' . $post->title . '</p>';
                        ?>
                    </div>

                    <div>
                        <?=
                        RHtmlHelper::linkAction(
                            'post',
                            'Reply(' . $post->commentCount . ')',
                            'view', $post->id . '#reply',
                            array('class' => 'btn btn-xs btn-info')) ?>
                        <?php
                        /*
                        $this->module("rating_plus",
                            array(
                                'id'=>'rating_plus',
                                'entityType'=>Topic::$entityType,
                                'entityId'=>$post->id,
                                'buttonClass'=>'btn btn-info btn-xs'
                            ));
                        */
                        ?>
                    </div>

                </div>
            </div>
            <hr>
        <?php } ?>

        <?= $pager ?>
    </div>
</div>