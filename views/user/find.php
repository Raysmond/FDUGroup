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
<div class="panel panel-default find-user">
    <div class="panel-heading">
        <h1 class="panel-title">Find Users</h1>
    </div>
    <div class="panel-body">
        <div class="navbar-right search-bar">
            <?= RForm::openForm('user/find', array('class' => 'form-signin find-group-form')); ?>
            <div class="col-lg-6" style="float:right;padding-top:10px;">
                <div class="input-group">
                    <input type="text" class="form-control" name="searchstr"
                           value="<?php echo urldecode($lastSearchStr); ?>"
                           placeholder="Search Users" />
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                </div>
            </div>
            <?= RForm::endForm() ?>
        </div>
        <div class="user-list">
            <?php
            if(empty($users)){
                echo '<div>&nbsp;&nbsp;No users found!</div>';
            }
            foreach ($users as $user) {
                echo '<div class="user-item col-lg-2">';
                $user->picture = $user->picture!=''?$user->picture:User::$defaults['picture'];
                $picture = RImage::styleSrc($user->picture, User::getPicOptions());
                echo '<a href="' . RHtml::siteUrl('user/view/' . $user->id) . '">' . RHtml::showImage($picture,$user->name,array("width"=>"64px","height"=>"64px")). '</a>';
                echo '<br/>';
                $name = $user->name;
                if (mb_strlen($name) > 7) $name = mb_substr($name, 0, 7) . "..";
                echo RHtml::linkAction('user', $name, 'view', $user->id, array('title' => $user->name)) . "  ";
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
