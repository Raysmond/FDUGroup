<?= RFormHelper::openForm('post/admin', array('id' => 'topicsAdminForm')) ?>
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            Topics
            <div class="navbar-right">
                <input type="submit" onclick="return confirm('Are you sure to delete selected topics?')" value="Delete" class="btn btn-xs btn-danger" />
            </div>
        </div>
        <table id="admin-topics" class="table">
            <thead>
            <tr>
                <?php echo '<th><input type="checkbox" id="check-all" onclick="javascript:checkReverse(\'checked_topics[]\')" /></th>'; ?>
                <th>Author</th>
                <th>Title</th>
                <th>Group</th>
                <th>Create Time</th>
                <th>Replies</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($topics as $topic) {
                echo '<tr>';
                echo '<td>' . RFormHelper::input(array('type' => 'checkbox', 'name' => 'checked_topics[]', 'value' => $topic['topic_id'])) . '</td>';
                echo '<td>' . RHtmlHelper::linkAction('user', $topic['user_name'], 'view', $topic['user_id']) . '</td>';
                echo '<td>' . RHtmlHelper::linkAction('post', $topic['topic_title'], 'view', $topic['topic_id']) . '</td>';
                echo '<td>' . RHtmlHelper::linkAction('group', $topic['group_name'], 'detail', $topic['group_id']) . '</td>';
                echo '<td>' . $topic['topic_created_time'] . '</td>';
                echo '<td>' . $topic['topic_comment_count'] . '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>
<?= RFormHelper::endForm() ?>
<?= $pager ?>