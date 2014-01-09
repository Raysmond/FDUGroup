<div class="panel panel-wrapper ">
    <div class="col-lg-3">
        <?php
        $groupPic = $group->picture ? $group->picture : Group::$defaults['picture'];
        echo RHtml::image(RImage::styleSrc($groupPic, Group::getPicOptions()), $group->name, array('width' => '120px', 'height' => '120px'));
        ?>
    </div>
    <div class="col-lg-9">
        <h2 style="margin: 5px 0;"><?= RHtml::linkAction('group', $group->name, 'detail', $group->id) ?></h2>
        <?= RHtml::linkAction('user', $manager->name, 'view', $manager->id); ?> created
        at <?= $group->createdTime ?>
        <br/>
        Category: <?= RHtml::linkAction('category', $group->category->name, 'groups', $group->categoryId) ?>
        <br/>
        Members: <?= $memberCount ?>
        <br/>
        Topics: <?= $topicCount ?>

    </div>

    <?php
    $isManager = false;
    if (Rays::isLogin() && Rays::user()->id == $manager->id) {
        $isManager = true;
    }
    ?>
    <?php
    if ($isManager) {
        echo RForm::openForm('group/members/' . $group->id, array('id' => 'removeMembersForm'));
    }
    ?>
    <div class="clearfix"></div>
    <hr>
    <div class="group-members panel panel-default">

        <div class="panel-heading">
            <?php
            if ($isManager) {
                echo '<div style="float: right;">';
                echo RForm::input(array('type' => 'Submit', 'value' => 'Remove members', 'class' => 'btn btn-danger btn-xs',
                    'onclick' => 'return confirm(\'Are you sure to remove the selected members from the group? This operation cannot be undone!\')'));
                echo '</div>';
            }
            ?>
            <b>Members (<?= count($members) ?>)</b>
        </div>

        <div class="members-list panel-body">
            <?php
            foreach ($members as $member) {
                ?>
                <div class="members-item" style="float:left;padding: 5px; height: 100px; width: 100px;">
                    <?php
                    $picture = $member->picture ? $member->picture : User::$defaults['picture'];
                    echo '<a href="' . RHtml::siteUrl('user/view/' . $member->id) . '">';
                    echo RHtml::image(RImage::styleSrc($picture, User::getPicOptions()), $member->name, array('width' => '64px', 'height' => '64px'));
                    echo '</a><br/>';
                    if ($isManager && $member->id != $manager->id) {
                        echo RForm::input(array('type' => 'checkbox', 'value' => $member->id, 'name' => 'selected_members[]'));
                        echo '&nbsp;';
                    }
                    $name = $member->name;
                    if (mb_strlen($name) > 7) $name = mb_substr($name, 0, 8) . "..";
                    echo RHtml::linkAction('user', $name, 'view', $member->id, array('title' => $member->name));
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    if ($isManager) {
        echo RForm::endForm();
    }
    ?>

</div>