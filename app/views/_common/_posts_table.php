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
