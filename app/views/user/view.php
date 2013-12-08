<?php
/**
 * User view page file.
 * @author: Raysmond
 */
?>

<?php
Rays::css("/public/css/post.css");
?>
<div class="panel panel-default">
    <div class="panel-body">

        <div class="user-profile-tiny">
            <?=$this->module('user_panel',array('userId'=>$user->id, 'viewUser' => true));?>
            <div class="navbar-right">
                <?php
                if (isset($canAdd)&&$canAdd) {
                    echo RHtmlHelper::linkAction('friend', '+ Add friend', 'add', $user->id, array('class' => 'btn btn-xs btn-info'));
                }
                if (isset($canCancel)&&$canCancel) {
                    echo RHtmlHelper::linkAction('friend', '- Cancel friend', 'cancel', $user->id, array('class' => 'btn btn-xs btn-danger'));
                }
                echo '<div class="clearfix"></div>';
                ?>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>

        <?php
        if ($user->status == User::STATUS_BLOCKED) {
            echo '<div class="panel-body">This user has been blocked.</div>';
        } else {
            ?>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li <?php if ($part == 'joins') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Joined Groups','view',$user->id)?></li>
                    <li <?php if ($part == 'posts') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Posts','view',[$user->id, 'posts'])?></li>
                    <li <?php if ($part == 'likes') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Favorites','view',[$user->id, 'likes'])?></li>
                    <li <?php if ($part == 'profile') echo 'class="active"';?>><?=RHtmlHelper::linkAction('user','Profile','view',[$user->id, 'profile'])?></li>
                </ul>
            </div>
            <?php $skip = ['id', 'status', 'picture', 'privacy', 'password', 'credits']; ?>
            <div class="panel-body">
                <?php
                if ($part == 'profile') {       //Profile of a User
                ?>
                <ul class="list-group">
                    <?php
                    foreach ($user->columns as $objCol => $dbCol) {
                        if ($user->$objCol && !in_array($objCol, $skip)) {
                            echo "<li class='list-group-item'>";
                            switch ($objCol) {
                                case "gender":
                                    echo "Gender: " . User::getGenderName($user->gender);
                                    break;
                                case "registerTime":
                                    echo "Register time: " . $user->registerTime . "<br/>";
                                    break;
                                case "qq":
                                    echo "QQ: " . $user->qq . "<br/>";
                                    break;
                                case "roleId":
                                    echo "Role: " . User::$roles[$user->roleId - 1] . "<br/>";
                                    break;
                                case "intro":
                                    echo "Introduction: " . $user->$objCol . "<br/>";
                                    break;
                                default:
                                    echo ucfirst($objCol) . ": " . $user->$objCol . "<br/>";
                                    break;
                            }
                            echo "</li>";
                        }
                    }
                    echo '</ul>';
                    } else if ($part == 'joins') {          //Groups joined by a User
                        if (empty($userGroup)) {
                            echo "<p>This guy has not joined any groups!</p>";
                        } else {
                            ?>
                            <div class="panel-my-group">
                                <div id="waterfall-groups" class="waterfall" style="margin: 0 -10px 0 -10px;">
                                    <?php
                                    $this->renderPartial("_common._groups_list",array('groups'=>$userGroup),false);
                                    ?>
                                </div>
                                <div class="clearfix"></div>
                                <div class="load-more-groups-processing" id="loading-groups">
                                    <div class="horizon-center">
                                        <img class="loading-24-24" src="<?=RHtmlHelper::siteUrl('/public/images/loading.gif')?>" /> loading...
                                    </div>
                                </div>
                                <a id="load-more-groups" href="javascript:loadMoreGroups()" class="btn btn-lg btn-primary btn-block">Load more groups</a>
                            </div>

                            <script>
                                var $container = $('#waterfall-groups');
                                var curPage = 1;
                                var loadCount = 0;
                                var isLoading = false;
                                var nomore = false;

                                $(document).ready(function(){
                                    $('#loading-groups').hide(0);
                                    $('#load-more-groups').hide(0);
                                    $container.masonry({
                                        columnWidth: 0,
                                        itemSelector: '.item'
                                    });

                                    $(window).scroll(function(){
                                        var height = $("#load-more-groups").position().top;
                                        var curHeight = $(window).scrollTop() + $(window).height();
                                        if(!isLoading&&curHeight>=height && !nomore){
                                            loadMoreGroups();
                                        }
                                    });
                                });


                                function loadMoreGroups(){
                                    isLoading = true;
                                    $('#loading-groups').show(0);
                                    //$('#load-more-groups').hide(0);
                                    $.ajax({
                                        url: "<?=RHtmlHelper::siteUrl('user/view/'.$user->id) ?>",
                                        type: "post",
                                        data:{page: ++curPage},
                                        success: function(data){
                                            $('#loading-groups').hide(0);
                                            //$('#load-more-groups').show(0);
                                            if (data == 'nomore') {
                                                nomore = true;
                                                $('#loading-groups').hide(0);
                                                //$('#load-more-groups').hide(0);
                                                return;
                                            }
                                            var $blocks = jQuery(data).filter('div.item');
                                            $("#waterfall-groups").append($blocks);
                                            $("#waterfall-groups").masonry('appended',$blocks);
                                            isLoading = false;
                                            loadCount++;
                                        }
                                    });
                                }

                            </script>

                    <?php
                        }
                    } else if ($part == 'posts') {         //User published Topics
                            $this->renderPartial("_common._posts_table",array('posts'=>$postTopics,'showGroup'=>true),false);
                        } else if ($part == 'likes') {
                                $this->renderPartial("_common._posts_table",array('posts'=>$likeTopics,'showAuthor'=>true,'showGroup'=>true),false);
                            }
                    ?>
                    <div>
                        <?=isset($pager)?$pager:"" ?>
                    </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>