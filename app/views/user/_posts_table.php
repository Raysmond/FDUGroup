<?php
if (empty($posts)) {
    echo "<p>No posts!</p>";
} else {
    ?>
    <table class="posts-table table table-hover table-condensed">
        <thead>
        <tr>
            <th>Title</th>
            <?=isset($showAuthor)&&$showAuthor? '<th>Author</th>':"" ?>
            <?=isset($showGroup)&&$showGroup? '<th>Group</th>':"" ?>
            <th>Replies</th>
            <th>Time</th>
        </tr>
        </thead>

        <tbody><?php
        foreach ($posts as $topic) {
            ?>
            <tr>
                <td><?= RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id) ?></td>
                <?php
                if(isset($showAuthor)&&$showAuthor){
                    echo '<td>'.RHtmlHelper::linkAction('user',$topic->user->name,'view',$topic->user->id).'</td>';
                }
                ?>
                <?php
                if(isset($showGroup)&&$showGroup){
                    echo '<td>'.RHtmlHelper::linkAction('group',$topic->group->name,'detail',$topic->group->id).'</td>';
                }
                ?>
                <td><?= $topic->commentCount ?></td>
                <td><?= $topic->createdTime ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php
}
