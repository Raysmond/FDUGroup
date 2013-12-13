<?php

if (empty($posts)) {
    echo "<p>No posts!</p>";
} else {
    ?>
    <table class="posts-table table table-hover table-condensed">
        <!--thead>
        <tr>
            <!th>Title</th>
            <?php //=isset($showAuthor)&&$showAuthor? '<th>Author</th>':"" ?>
            <?php //=isset($showGroup)&&$showGroup? '<th>Group</th>':"" ?>
            <th>Replies</th>
            <th>Time</th>
        </tr>
        </thead-->

        <tbody><?php
        foreach ($posts as $topic) {
            ?>
            <tr>
                <td class="post-list-td1"><?= RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id) ?></td>
                <?php
                if(isset($showAuthor)&&$showAuthor){
                    echo '<td class="post-list-td2">by '.RHtmlHelper::linkAction('user',$topic->user->name,'view',$topic->user->id).'</td>';
                }
                ?>
                <?php
                if(isset($showGroup)&&$showGroup){
                    echo '<td class="post-list-td3">'.RHtmlHelper::linkAction('group',$topic->group->name,'detail',$topic->group->id).'</td>';
                }
                ?>
                <td class="post-list-td4"><?= $topic->commentCount ?> replies</td>
                <td class="post-list-td5"><?= mb_substr($topic->createdTime, 0, 10) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php
}
?>
<script>
$(document).ready(function() {
    $(".post-list-td1").dotdotdot({
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
            height		: 25
        }
    );
    $(".post-list-td2").dotdotdot({
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
            height		: 25
        }
    );
    $(".post-list-td3").dotdotdot({
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
            height		: 25
        }
    );
    $(".post-list-td4").dotdotdot({
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
            height		: 25
        }
    );
});
</script>