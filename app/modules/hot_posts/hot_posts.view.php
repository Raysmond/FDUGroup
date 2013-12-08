<div class="panel panel-default">
    <div class="panel-heading">Today's hot posts</div>
    <div class="panel-body">
        <ul id="day-top-posts-list" class="top-posts-list">
            <?php
            foreach($posts as $post){
                echo '<li class="post-item">';
                echo '<span class="counter">'.$post['daycount'].'</span>';
                echo RHtmlHelper::linkAction('post',$post['top_title'],'view',$post['top_id']);
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#day-top-posts-list li a").dotdotdot({
            /*	The HTML to add as ellipsis. */
            ellipsis	: '... ',

            /*	How to cut off the text/html: 'word'/'letter'/'children' */
            wrap		: 'letter',

            /*	Wrap-option fallback to 'letter' for long words */
            fallbackToLetter: true,

            /*	jQuery-selector for the element to keep and put after the ellipsis. */
            after		: null,

            /*	Whether to update the ellipsis: true/'window' */
            watch		: false,

            /*	Optionally set a max-height, if null, the height will be measured. */
            height		: 30
        });
    });
</script>