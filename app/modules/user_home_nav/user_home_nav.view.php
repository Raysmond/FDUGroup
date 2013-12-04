<div class="panel panel-default">
    <div class="panel-heading"><b>Navigation</b></div>
    <div class="panel-body">
    <ul class="nav nav-pills nav-stacked">

        <li <?= (Rays::app()->getHttpRequest()->urlMatch(array('user/home','user','user/'), $currentUrl)) ? 'class="active"' : "" ?>>
            <?= RHtmlHelper::linkAction('user', 'Latest posts', 'home') ?>
        </li>

        <li <?= (Rays::app()->getHttpRequest()->urlMatch(array('user/myposts','user/myposts?*'), $currentUrl)) ? 'class="active"' : "" ?>>
            <?=RHtmlHelper::linkAction('user','My posts', 'myposts')?>
        </li>

        <li <?= ($currentUrl == 'group/view') ? 'class="active"' : "" ?>>
            <?= RHtmlHelper::linkAction('group', 'My Groups', 'view') ?>
        </li>

        <li <?= ($currentUrl == 'user/profile') ? 'class="active"' : "" ?>>
            <?= RHtmlHelper::linkAction('user', 'Profile', 'profile') ?>
        </li>

        <?php
        $isMessageUrl = Rays::app()->getHttpRequest()->urlMatch('message/*', $currentUrl);
        if (($count = $user->countUnreadMsgs()) == 0) {
            echo "<li " . ($isMessageUrl ? 'class="active"' : "") . ">" . RHtmlHelper::linkAction("message", "Messages", "view", null) . "</li>";
        } else {
            echo '<li ' . ($isMessageUrl ? 'class="active"' : "") . '><a href="' . RHtmlHelper::siteUrl('message/view') . '">';
            echo 'Messages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="badge">' . $count . '</span></a></li>';
        }

        if ($user->roleId == Role::VIP_ID) {
        ?>
            <li <?= (Rays::app()->getHttpRequest()->urlMatch(array('ads/view','ads/view/*'), $currentUrl)) ? 'class="active"' : "" ?>>
                <a href="<?=RHtmlHelper::siteUrl('ads/view')?>">
                    Advertisement&nbsp;&nbsp;<span class="badge badge-vip">VIP</span>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
    </div>
</div>