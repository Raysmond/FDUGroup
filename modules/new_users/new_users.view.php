<div class="panel panel-default">
    <div class="panel-heading"><h3 class="panel-title">New Users</h3></div>
    <div class="panel-body">
        <?php
        echo '<div class="row user-list">';
        foreach ($users as $user) {
            echo '<div class="user-item col-lg-4">';
            $picture = isset($user->picture) && $user->picture != '' ? $user->picture : User::$defaults['picture'];
            $picture = RImage::styleSrc($picture, User::getPicOptions());
            echo '<a href="' . RHtml::siteUrl('user/view/' . $user->id) . '">' . RHtml::image($picture, $user->name, array('width' => '64px', 'height' => '64px')) . '</a>';
            $name = $user->name;
            if (mb_strlen($name) > 7) $name = mb_substr($name, 0, 8) . "..";
            echo RHtml::linkAction('user', $name, 'view', $user->id, array('title' => $user->name)) . "  ";
            echo '</div>';
        }
        echo '</div>';
        ?>

    </div>
</div>