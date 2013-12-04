<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
$form = array();
if (isset($searchForm)) {
    $form = $searchForm;
}
$lastSearchStr = isset($searchstr) ? $searchstr : "";
if ($lastSearchStr != '')
    $lastSearchStr = urlencode($lastSearchStr);
?>
<div class="panel panel-default row find-user">
    <div class="panel panel-heading" style="font-weight: bold;">
        Find Users
    </div>
    <div class="panel-body">
        <div class="navbar-right search-bar">
            <?= RFormHelper::openForm('user/find', array('class' => 'form-signin find-group-form')); ?>
            <div class="col-lg-6" style="float:right;">
                <div class="input-group">
                    <input type="text" class="form-control" name="searchstr"
                           value="<?php echo urldecode($lastSearchStr); ?>"
                           placeholder="Search Users" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                </div>
            </div>
            <?= RFormHelper::endForm() ?>
        </div>
        <div class="user-list">
            <?php
            if(empty($users)){
                echo '<div>&nbsp;&nbsp;No users found!</div>';
            }
            foreach ($users as $user) {
                echo '<div class="user-item col-lg-2">';
                $user->picture = $user->picture!=''?$user->picture:User::$defaults['picture'];
                $picture = RImageHelper::styleSrc($user->picture,User::getPicOptions());
                echo '<a href="' . RHtmlHelper::siteUrl('user/view/' . $user->id) . '">' . RHtmlHelper::showImage($picture,$user->name,array("width"=>"64px","height"=>"64px")). '</a>';
                $name = $user->name;
                if (mb_strlen($name) > 7) $name = mb_substr($name, 0, 8) . "..";
                echo RHtmlHelper::linkAction('user', $name, 'view', $user->id, array('title' => $user->name)) . "  ";
                echo '</div>';
            }
            ?>
        </div>
        <div class="clearfix"></div>
        <div>
            <?=(isset($pager)?$pager:"")?>
        </div>
    </div>
</div>
