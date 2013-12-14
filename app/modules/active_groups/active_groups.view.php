<div class="panel panel-default">
    <div class="panel-heading">Popular Groups</div>
    <div class="panel-body popular-groups">
        <?php if(empty($groups)): ?>
            <p>No groups</p>
        <?php endif; ?>
        <ul>
        <?php
            foreach ($groups as $group) {
                ?>
                <li>
                    <div class="popular-group-picture">
                        <a href="<?=RHtmlHelper::siteUrl('group/detail/'.$group->id)?>">
                            <?= RHtmlHelper::showImage(RImageHelper::styleSrc($group->picture?:Group::$defaults['picture'], Group::getPicOptions()), $group->name); ?>
                        </a>
                    </div>
                    <div class="popular-group-title">
                        <a href="<?=RHtmlHelper::siteUrl('group/detail/'.$group->id)?>">
                            <?= $group->name?>
                        </a>
                    </div>
                    <div class="popular-group-cat">
                        <a href="<?=RHtmlHelper::siteUrl('category/groups/'.$group->categoryId)?>">
                            <?= $group->category->name?>
                        </a>
                    </div>
                </li>
                <?php
            }
        ?>
        </ul>
    </div>
</div>