<?php
/**
 * @author: Raysmond
 */
?>
<div>
        <div id="latest-topics-list">
        <?php $this->renderPartial('_posts_list',array('topics'=>$topics),false); ?>
        </div>
        <div id="topics-list-footer" style="text-align: center;">
            <?php
            if (count($topics) > 0) {
                echo RFormHelper::openForm('user/home', array('id' => 'loadMorePostsForm'));
                echo RFormHelper::hidden(array(
                        'id' => 'last-loaded-time',
                        'name' => 'last-loaded-time',
                        'value' => $topics[count($topics) - 1]['top_created_time'])
                );
                echo RHtmlHelper::link(
                    'Load more posts',
                    'Load more posts',
                    "javascript:loadMorePosts()",
                    array('class' => 'btn btn-lg btn-primary', 'id' => 'get_more_post_btn'));
                echo RFormHelper::endForm();
            } else {
                echo 'No posts yet. ';
            }
            ?>
        </div>

</div>
<script>
    function loadMorePosts() {
        $("#get_more_post_btn").addClass('disabled');
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
                }
                else{
                    $('#latest-topics-list').append(data.content);
                    $('#last-loaded-time').val(data.lastLoadTime);
                    $("#get_more_post_btn").removeClass('disabled');
                }
            });
    }
</script>


