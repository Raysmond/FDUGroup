<?= RFormHelper::openForm('comment/admin', array('id' => 'commentAdminForm')) ?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        Comments
        <div class="navbar-right">
            <?= RFormHelper::input(array('type' => 'submit', 'value' => 'Delete', 'class' => 'btn btn-sm btn-danger')) ?>
        </div>
    </div>
    <table id="admin-comments" class="table">
        <thead>
        <tr>
            <?php echo '<th><input type="checkbox" id="check-all" onclick="javascript:checkReverse(\'checked_comments[]\')" /></th>'; ?>
            <th>Author</th>
            <th>Create Time</th>
            <th>Topic</th>
            <th>Content</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($comments as $comment) {
            echo '<tr>';
            echo '<td>' . RFormHelper::input(array('name' => 'checked_comments[]', 'type' => 'checkbox', 'value' => $comment['comment_id'])) . '</td>';
            echo '<td>' . RHtmlHelper::linkAction('user', $comment['user_name'], 'view', $comment['comment_user_id']) . '</td>';
            echo '<td>' . $comment['comment_created_time'] . '</td>';
            if (mb_strlen($comment['comment_content']) > 140) {
                $comment['comment_content'] = mb_substr($comment['comment_content'], 0, 140, 'UTF-8') . '...';
            }
            echo '<td>' . RHtmlHelper::linkAction('post', $comment['topic_title'], 'view', $comment['comment_topic_id']) . '</td>';
            echo '<td>', $comment['comment_content'] . '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?= RFormHelper::endForm() ?>

<?= $pager ?>
