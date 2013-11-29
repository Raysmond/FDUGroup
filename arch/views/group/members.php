<div class="row">
    <div class="col-lg-2">
        <?php
        $groupPic = $group->picture ? $group->picture : Group::$defaults['picture'];
        echo RHtmlHelper::showImage(RImageHelper::styleSrc($groupPic, Group::getPicOptions()), $group->name, array('width' => '120px', 'height' => '120px'));
        ?>
    </div>
    <div class="col-lg-10">
        <h2 style="margin: 5px 0;"><?= RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id) ?></h2>
        <?= RHtmlHelper::linkAction('user', $manager->name, 'view', $manager->id); ?> created
        at <?= $group->createdTime ?>
        <br/>
        <?php $group->category->load(); ?>
        Category: <?= RHtmlHelper::linkAction('category', $group->category->name, 'groups', $group->categoryId) ?>
        <br/>
        Members: <?= $memberCount ?>
        <br/>
        Topics: <?= $topicCount ?>

    </div>

</div>
<hr>

<?php
$isManager = false;
if (Rays::app()->isUserLogin() && Rays::app()->getLoginUser()->id == $manager->id) {
    $isManager = true;
}
?>
<?php
if ($isManager) {
    echo RFormHelper::openForm('group/members/' . $group->id, array('id' => 'removeMembersForm'));
}
?>
<div class="group-members panel panel-default">

    <div class="panel-heading">
        <?php
        if ($isManager) {
            echo '<div style="float: right;">';
            echo RFormHelper::input(array('type' => 'Submit', 'value' => 'Remove members', 'class' => 'btn btn-danger btn-xs',
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
                echo '<a href="' . RHtmlHelper::siteUrl('user/view/' . $member->id) . '">';
                echo RHtmlHelper::showImage(RImageHelper::styleSrc($picture, User::getPicOptions()), $member->name, array('width' => '64px', 'height' => '64px'));
                echo '</a><br/>';
                if ($isManager) {
                    echo RFormHelper::input(array('type' => 'checkbox', 'value' => $member->id, 'name' => 'selected_members[]'));
                    echo '&nbsp;';
                }
                $name = $member->name;
                if (mb_strlen($name) > 7) $name = mb_substr($name, 0, 8) . "..";
                echo RHtmlHelper::linkAction('user', $name, 'view', $member->id, array('title' => $member->name));
                ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<?php
if ($isManager) {
    echo RFormHelper::endForm();
}
?>