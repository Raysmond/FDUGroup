<div class="user-home-navigation">
    <ul class="nav nav-pills nav-stacked">

        <li <?= (Rays::app()->getHttpRequest()->urlMatch(array('user/home','user','user/'), $currentUrl)) ? 'class="active"' : "" ?>>
            <a href="<?=RHtmlHelper::siteUrl('user/home')?>">
                <span class="glyphicon glyphicon-home"></span> &nbsp; Home
            </a>
        </li>

        <li <?= (Rays::app()->getHttpRequest()->urlMatch(array('user/myposts','user/myposts?*'), $currentUrl)) ? 'class="active"' : "" ?>>
            <a href="<?=RHtmlHelper::siteUrl('user/myposts')?>">
                <span class="glyphicon glyphicon-list-alt"></span> &nbsp; My posts
            </a>
        </li>

        <li <?= ($currentUrl == 'group/mygroups') ? 'class="active"' : "" ?>>
            <a href="<?=RHtmlHelper::siteUrl('group/mygroups')?>">
                <span class="glyphicon glyphicon-th-large"></span> &nbsp; My groups
            </a>
        </li>

        <li <?= ($currentUrl == 'user/profile') ? 'class="active"' : "" ?>>
            <a href="<?=RHtmlHelper::siteUrl('user/profile')?>">
                <span class="glyphicon glyphicon-user"></span> &nbsp; My profile
            </a>
        </li>

        <li <?= ($currentUrl == 'friend/myfriend') ? 'class="active"' : "" ?>>
            <a href="<?=RHtmlHelper::siteUrl('friend/myfriend')?>">
                <span class="glyphicon glyphicon-heart"></span> &nbsp; My friends
            </a>
        </li>

        <?php
        $isMessageUrl = Rays::app()->getHttpRequest()->urlMatch('message/*', $currentUrl);
        if (($count = $user->countUnreadMsgs()) == 0) {
            echo "<li " . ($isMessageUrl ? 'class="active"' : "") . ">";
            ?>
            <a href="<?=RHtmlHelper::siteUrl('message/view')?>"><span class="glyphicon glyphicon-envelope"></span> &nbsp; Messages</a>
            <?php
            echo "</li>";
        } else {
            echo '<li ' . ($isMessageUrl ? 'class="active"' : "") . '><a href="' . RHtmlHelper::siteUrl('message/view') . '">';
            echo '<span class="glyphicon glyphicon-envelope"></span> &nbsp; ';
            echo 'Messages <span class="badge">' . $count . '</span></a></li>';
        }

        if ($user->roleId == Role::VIP_ID) {
        ?>
            <li <?= (Rays::app()->getHttpRequest()->urlMatch(array('ads/view','ads/view/*'), $currentUrl)) ? 'class="active"' : "" ?>>
                <a href="<?=RHtmlHelper::siteUrl('ads/view')?>">
                    <span class="glyphicon glyphicon-euro"></span> &nbsp;
                    Advertisement <span class="badge badge-vip">VIP</span>
                </a>
            </li>
        <?php
        }
        ?>
    </ul>
</div>