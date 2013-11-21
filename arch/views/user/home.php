<?php
/**
 * Author: Raysmond
 */
?>
<div class="row panel panel-default">
    <div class="panel-heading"><b>Latest posts</b></div>
    <div class="panel-body">
        <div id="latest-topics-list">
            <?php
            foreach ($topics as $topic) {
                ?>
                <div class="row topic-item">
                    <div class="col-lg-2 topic-picture">
                        <?php if ($topic['u_picture'] == '') {
                            $topic['u_picture'] = User::$defaults['picture'];
                        }?>
                        <?= RHtmlHelper::showImage($topic['u_picture'], $topic['u_name'], array('width' => '64px')) ?>

                    </div>
                    <div class="col-lg-10 topic-content">
                        <div><?= RHtmlHelper::linkAction('post', $topic['top_title'], 'view', $topic['top_id']) ?></div>
                        <div class="topic-meta">
                            <?= RHtmlHelper::linkAction('user', $topic['u_name'], 'view', $topic['u_id']) ?>
                            post
                            in <?= RHtmlHelper::linkAction('group', $topic['gro_name'], 'detail', $topic['gro_id']) ?>
                            &nbsp;&nbsp;<?= $topic['top_created_time'] ?>
                        </div>
                        <div>
                            <?php
                            $topic['top_content'] = strip_tags(RHtmlHelper::decode($topic['top_content']));
                            if (mb_strlen($topic['top_content']) > 140) {
                                echo '<p>' . mb_substr($topic['top_content'], 0, 140, 'UTF-8') . '...</p>';
                            } else echo '<p>' . $topic['top_content'] . '</p>';
                            ?>
                        </div>

                        <div>
                            <?= RHtmlHelper::linkAction('post', 'Reply(' . $topic['top_comment_count'] . ')', 'view', $topic['top_id'] . '#reply') ?>
                        </div>

                    </div>
                </div>
                <hr>
            <?php
            }
            ?>
        </div>
        <!--END last-topics-list-->

        <?php
        if (count($topics) > 0) {
            echo RFormHelper::openForm('user/home', array('id' => 'loadMorePostsForm'));
            echo RFormHelper::hidden(array('id' => 'last-loaded-time', 'name' => 'last-loaded-time', 'value' => $topics[count($topics) - 1]['top_created_time']));
            echo RHtmlHelper::link('Load more posts', 'Load more posts', "javascript:loadMorePosts()", array('class' => 'btn btn-lg btn-primary btn-block', 'id' => 'get_more_post_btn'));
            echo RFormHelper::endForm();
        } else {
            echo 'No posts yet. ';
        }
        ?>
    </div>
</div>
<script>
    function loadMorePosts() {
        $.ajax({
            type: "POST",
            url: $('#loadMorePostsForm').attr('action'),
            data: { 'lastLoadedTime': $('#last-loaded-time').val() }
        })
            .done(function (data) {
                //alert(data);
                var json = eval('(' + data + ')');
                var html = '';
                for (var i = 0; i < json.length; ++i) {
                    var item = json[i];
                    html += '<div class="row topic-item"><div class="col-lg-2 topic-picture">';
                    html += '<img src="' + item['user_picture'] + '" width="64px" title="' + item['user_name'] + '" />';
                    html += '</div>';

                    html += '<div class="col-lg-10 topic-content">';

                    html += '<div><a href="' + item['topic_link'] + '" title="' + item['topic_title'] + '">'
                        + item['topic_title'] + '</a></div>';

                    html += '<div class="topic-meta">';
                    html += '<a href="' + item['user_link'] + '" title="' + item['user_name'] + '">' + item['user_name'] + '</a>';
                    html += ' post in ' + '<a href="' + item['group_link'] + '" title="' + item['group_name'] + '">' + item['group_name'] + '</a>';
                    html += '&nbsp;&nbsp;' + item['topic_created_time'];
                    html += '</div>'; //end of meta
                    html += '<div>' + item['topic_content'] + '</div>';
                    html += '<div>';
                    html += '<a href="' + item['topic_link'] + '#reply" title="Reply post">Reply(' + item['topic_reply_count'] + ')</a></div>';
                    html += '</div>'; //end of content

                    html += '</div><hr>';
                }
                if (html != '') {
                    $('#latest-topics-list').append(html);
                    $('#last-loaded-time').val(json[json.length - 1]['topic_created_time']);
                }
                else if (!$("#no_more_post").html()) {
                    $('#latest-topics-list').append('<span id="no_more_post" style="color:red;">No more posts..</span>.<br/><br/>');
                    $('#get_more_post_btn').remove();
                }
            });
    }
</script>


