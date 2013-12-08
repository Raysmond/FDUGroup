<div class="row user-panel">
    <?php if ($user != null): ?>
        <div class="row user-profile-tiny">
            <div class="user-picture">
                <?php if (!isset($user->picture) || $user->picture == '') $user->picture = User::$defaults['picture'];
                    $thumbnail = RImageHelper::styleSrc($user->picture, $user::getPicOptions());
                ?>
                <a href="<?= RHtmlHelper::siteUrl('user/view/' . $user->id) ?>">
                    <?php
                    echo RHtmlHelper::showImage($thumbnail, $user->name, array('class' => 'img-thumbnail', 'width' => isset($viewUser)?'80px':'120px'))
                    ?>
                </a>
            </div>

            <div class="user-statistics">
                <div class="stat-item">
                    <div class="number">
                        <?= $user->countFriends($user->id) ?>
                    </div>
                    <div class="text">
                        Friends
                    </div>
                </div>
                <div class="stat-item">
                    <div class="number">
                        <?= $user->countGroups($user->id) ?>
                    </div>
                    <div class="text">
                        Groups
                    </div>
                </div>
                <div class="stat-item">
                    <div class="number">
                        <?= $user->countPosts($user->id) ?>
                    </div>
                    <div class="text">
                        Posts
                    </div>
                </div>
            </div>

            <div class="user-profile">
                <h2>
                    <?= RHtmlHelper::linkAction('user', $user->name, 'view', $user->id, ['style' => 'float:left;']) ?>&nbsp;
                    <div class="badge-user-panel"><span class="badge badge-<?= Role::getRoleNameById($user->roleId); ?>"><?= Role::getBadgeById($user->roleId); ?></span></div>
                </h2>

                <div class="user-introduction"><?= RHtmlHelper::decode($user->intro) ?></div>
                <div class="user-info">
                    <div title="gender: <?=User::getGenderName($user->gender)?>" class="user-gender user-gender-<?=User::getGenderName($user->gender)?>"></div>
                    <?= ($user->region ? '<span class="spliter">|</span>'.$user->region:''); ?>
                    <?php if ($user->weibo != '') { ?>
                        <?php if ($user->region != '') { ?><span class="spliter">|</span><?php } ?>
                        Micro-Blog: <?= RHtmlHelper::link($user->weibo, $user->weibo, $user->weibo) ?>
                    <?php } ?>
                </div>
            </div>

        </div>

    <?php endif; ?>
</div>
