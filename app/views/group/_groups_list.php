<?php
foreach ($groups as $group) {
    ?>
    <div class="item col-lg-4">
        <?php
        if ($group->picture) {
            ?>
            <div class="group-picture"> <?php
                $picture = RImageHelper::styleSrc($group->picture, Group::getPicOptions());
                echo RHtmlHelper::showImage($picture, $group->name);
                ?> </div> <?php
        }
        ?>
        <div class='item-heading'>
            <?php
            echo RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id);
            ?> </div> <?php

        ?>
        <div class="item-body">
            <?php
            $group->intro = strip_tags(RHtmlHelper::decode($group->intro));
            if (mb_strlen($group->intro) > 100) {
                echo '<p>' . mb_substr($group->intro, 0, rand(60, 150), 'UTF-8') . '...</p>';
            } else echo '<p>' . $group->intro . '</p>';

            ?>

        </div>

        <div class="actions">
            <div class="action">
                <span class="glyphicon glyphicon-user"></span>
                <?=$group->memberCount?>
            </div>
            <div class="action action-like">
                <?php
                $this->module('rating_plus', array('id' => 'rating_plus', 'entityType' => Group::ENTITY_TYPE, 'entityId' => $group->id));
                ?>
            </div>

            <?php
            if (Rays::app()->isUserLogin()) {
                $g_u = new GroupUser();
                $g_u->userId = Rays::app()->getLoginUser()->id;
                $g_u->groupId = $group->id;
                if (count($g_u->find()) == 0) {
                    ?>
                <div class="action">
                    <a href="#"><span class="glyphicon glyphicon-plus"></span></a>
                </div>
                <?php
                }
            }

            if (isset($exitGroup)) {
                ?>
                <div class="action">
                    <a href="<?=RHtmlHelper::siteUrl("group/exit/".$group->id)?>" onclick='javascript:confirmExit(<?=$group->id?>)'><span class="glyphicon glyphicon-remove"></span></a>
                </div>
                <?php
            }
            ?>
        </div>

        <?php
        ?> </div> <?php
}