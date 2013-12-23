<?php
foreach ($groups as $group) {
    ?>
    <div class="item col-lg-4">
        <!-- Group name -->
        <div class='item-heading'>
            <?= RHtml::linkAction('group', $group->name, 'detail', $group->id); ?>
        </div>

        <!-- Group picture -->
        <?php if ($group->picture) { ?>
            <div class="group-picture">
                <a href="<?=RHtml::siteUrl('group/detail/'.$group->id)?>">
                    <?= RHtml::showImage(RImage::styleSrc($group->picture, Group::getPicOptions()), $group->name); ?>
                </a>
            </div>
        <?php } ?>

        <!-- Group intro -->
        <div class="item-body">
            <?php
            $group->intro = (strip_tags(RHtml::decode($group->intro)));
            if (mb_strlen($group->intro) > 100) {
                echo '<p>' . preg_replace('/&.{0,5}\.\.\.$/', '...', mb_substr($group->intro, 0, rand(60, 150), 'UTF-8') . '...').'</p>';
            } else {
                echo '<p>' . $group->intro . '</p>';
            }
            ?>

        </div>

        <!-- Group actions -->
        <div class="actions">

            <div class="action">
                <a href="javascript:void(0);" title="Members of this group">
                    <span class="glyphicon glyphicon-user"></span> <?= $group->memberCount ?>
                </a>
            </div>

            <div class="action action-like">
                <?php $self->module('rating_plus', array('id' => 'rating_plus', 'entityType' => Group::ENTITY_TYPE, 'entityId' => $group->id)); ?>
            </div>

            <?php
            if (Rays::isLogin()) {
                if (!GroupUser::isUserInGroup(Rays::user()->id,$group->id)) {
                    ?>
                    <div class="action action-right">
                        <?php $url = RHtml::siteUrl('group/join'); ?>
                        <a href="javascript: joinGroup('<?=$url?>','<?=$group->id?>')" title="Join the group"><span class="glyphicon glyphicon-plus"></span></a>
                    </div>
                <?php
                }
            }

            if (isset($exitGroup)) {
                ?>
                <div class="action action-right">
                    <a title="Exit this group" href="<?= RHtml::siteUrl("group/exit/" . $group->id) ?>"
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