<?php
/**
 * @author: Raysmond
 */
?>
<div>
        <div id="latest-topics-list">
        <?php $self->renderPartial('_posts_list',array('topics'=>$topics),false); ?>
        </div>
        <div id="topics-list-footer" style="text-align: center;">
            <?php
            if (count($topics) > 0) {
                echo RForm::openForm('user/home', array('id' => 'loadMorePostsForm'));
                echo RForm::hidden(array(
                        'id' => 'last-loaded-time',
                        'name' => 'last-loaded-time',
                        'value' => $topics[count($topics) - 1]->createdTime)
                );
                echo RHtml::link(
                    'Load more posts',
                    'Load more posts',
                    "javascript:loadMorePosts()",
                    array('class' => 'btn btn-lg btn-primary', 'id' => 'get_more_post_btn'));
                echo RForm::endForm();
            } else {
                echo 'No posts yet. ';
            }
            ?>
        </div>

</div>
<script>
    var isLoading = false;
    var nomore = false;

    $(document).ready(function () {
        $(window).scroll(function () {
            if (!nomore) {
                var height = $("#get_more_post_btn").position().top;
                console.log(height);
                var curHeight = $(window).scrollTop() + $(window).height();
                if (!isLoading && curHeight >= height+100) {
                    loadMorePosts();
                }
            }
        });
    });

    function loadMorePosts() {
        isLoading = true;
        $("#get_more_post_btn").addClass('disabled');
        $("#get_more_post_btn").html('<img style="width:20px;height:20px;" src="<?= RHtml::siteUrl('/public/images/loading.gif') ?>" /> loading...');
        $.ajax({
            type: "POST",
            url: $('#loadMorePostsForm').attr('action'),
            data: { 'lastLoadedTime': $('#last-loaded-time').val() }
        })
            .done(function (data) {
                data = eval('('+data+')');
                if(data.content==''){
                    $('#topics-list-footer').append('<span id="no_more_post" style="color:red;">No more posts..</span>.<br/><br/>');
                    $('#get_more_post_btn').remove();
                    nomore = true;
                }
                else{
                    $('#latest-topics-list').append(data.content);
                    $('#last-loaded-time').val(data.lastLoadTime);
                    $("#get_more_post_btn").removeClass('disabled');
                    $("#get_more_post_btn").html('Load more posts');
                }
                isLoading = false;
            });
    }
</script>


