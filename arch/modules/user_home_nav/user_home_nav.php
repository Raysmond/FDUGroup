<div class="panel panel-default">
    <div class="panel-heading"><b>Navigation</b></div>
    <div class="panel-body">
    <ul class="nav nav-pills nav-stacked">
        <li <?= ($currentUrl == 'user/home') ? 'class="active"' : "" ?>>
            <?= RHtmlHelper::linkAction('user', 'Home page', 'home') ?>
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
        ?>
    </ul>
    </div>
</div>