<?php
/**
 * Group detail page
 * @author: Raysmond
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h1 class="panel-title"><?= $group->name ?></h1></div>
    <div class="panel-body">
        <div class="row">
            <?php
            if (isset($group->picture) && $group->picture != '') {
                echo '<div class="col-xs-3 group-picture">';
                $picture = RImageHelper::styleSrc($group->picture, Group::getPicOptions());
                echo RHtmlHelper::showImage($picture, $group->name,
                    array('class' => 'img-thumbnail', 'style' => 'width:200px;'));
                echo '</div>';
            }
            ?>

            <div class="group-content col-xs-9">
                <div class="group-meta">
                    <span
                        class="glyphicon glyphicon-tag"></span> <?= RHtmlHelper::linkAction('category', $group->category->name, 'groups', $group->category->id); ?>
                    &nbsp;
                    <span class="glyphicon glyphicon-user"></span> <?= $group->memberCount ?>
                    &nbsp;
                    <span class="glyphicon glyphicon-search"></span> <?= $counter ?>
                    &nbsp;
                    <?= RHtmlHelper::linkAction('user', $group->groupCreator->name, 'view', $group->creator) ?>
                    created at
                    <?= $group->createdTime ?>

                </div>

                <div class="group-intro"><?php echo RHtmlHelper::decode($group->intro); ?></div>
            </div>
        </div>


        <!-- Latest posts -->
        <div class="row group-posts">
            <div class="col-sm-6">
                <h2 class="s-title">Latest Posts</h2>
            </div>
            <div class="col-sm-3" style="float:right;text-align: right;">
                <?php if ($hasJoined) echo RHtmlHelper::linkAction('post', "Add new post", 'new', $group->id,
                    array('class' => 'btn btn-xs btn-success', 'style' => 'margin: 10px 0;')) ?>
            </div>

            <div class="clearfix"></div>

            <div>
                <?php if (count($latestPosts) > 0): ?>
                    <table class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Replies</th>
                            <th>Time</th>
                            <th>Last comment</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($latestPosts as $topic) {
                            ?>
                            <tr>
                            <td><b><?= RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id) ?></b></td>
                            <td><?= RHtmlHelper::linkAction('user', $topic->user->name, 'view', $topic->user->id) ?></td>
                            <td><?= $topic->commentCount ?></td>
                            <td><?= $topic->createdTime ?></td>
                            <td><?= $topic->lastCommentTime ?></td></tr><?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <ul class="pager">
                        <li class="next"><a href="<?= RHtmlHelper::siteUrl('post/list/' . $group->id) ?>">More
                                topics &rarr;</a>
                        </li>
                    </ul>
                <?php endif; ?>
                <?= (count($latestPosts) == 0) ? "No posts." : "" ?>
            </div>

        </div>
    </div>

</div>