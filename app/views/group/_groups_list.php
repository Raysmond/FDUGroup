<?php
foreach ($groups as $group) {
    ?>
    <div class="item col-lg-4">

        <!-- Group picture -->
        <?php if ($group->picture) { ?>
            <div class="group-picture">
                <a href="<?=RHtmlHelper::siteUrl('group/detail/'.$group->id)?>">
                    <?= RHtmlHelper::showImage(RImageHelper::styleSrc($group->picture, Group::getPicOptions()), $group->name); ?>
                </a>
            </div>
        <?php } ?>

        <!-- Group name -->
        <div class='item-heading'>
            <?= RHtmlHelper::linkAction('group', $group->name, 'detail', $group->id); ?>
        </div>

        <!-- Group intro -->
        <div class="item-body">
            <?php
            $group->intro = strip_tags(RHtmlHelper::decode($group->intro));
            if (mb_strlen($group->intro) > 100) {
                echo '<p>' . mb_substr($group->intro, 0, rand(60, 150), 'UTF-8') . '...</p>';
            } else {
                echo '<p>' . $group->intro . '</p>';
            }
            ?>

        </div>

        <!-- Group actions -->
        <div class="actions">

            <div class="action">
                <span class="glyphicon glyphicon-user"></span> <?= $group->memberCount ?>
            </div>

            <div class="action action-like">
                <?php $this->module('rating_plus', array('id' => 'rating_plus', 'entityType' => Group::ENTITY_TYPE, 'entityId' => $group->id)); ?>
            </div>

            <?php
            if (Rays::app()->isUserLogin()) {
                if (!GroupUser::isUserInGroup(Rays::app()->getLoginUser()->id,$group->id)) {
                    ?>
                    <div class="action">
                        <?php $url = RHtmlHelper::siteUrl('group/join'); ?>
                        <a href="javascript: joinGroup('<?=$url?>','<?=$group->id?>')" title="Join the group"><span class="glyphicon glyphicon-plus"></span></a>
                    </div>
                <?php
                }
            }

            if (isset($exitGroup)) {
                ?>
                <div class="action">
                    <a href="<?= RHtmlHelper::siteUrl("group/exit/" . $group->id) ?>"
                       onclick='javascript:return confirm("Do you really want to exit this group?")'><span
                            class="glyphicon glyphicon-remove"></span></a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
?>

<script>
    function joinGroup(url, groupId){
        $.ajax({
            url: url+'/'+groupId,
            type: 'post',
            success: function(data){
                data = eval('('+data+')');
                alert(data.text);
            }
        });
    }
</script>