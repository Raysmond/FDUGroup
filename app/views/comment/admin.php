<?= RFormHelper::openForm('comment/admin', array('id' => 'commentAdminForm')) ?>
<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">
        Comments
        <div class="navbar-right">
            <input type="submit" onclick="return confirm('Are you sure to delete selected comments?')" value="Delete" class="btn btn-xs btn-danger" />
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
            <th>View</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($comments as $comment) {
            echo '<tr>';
            echo '<td>' . RFormHelper::input(array('name' => 'checked_comments[]', 'type' => 'checkbox', 'value' => $comment->id)) . '</td>';
            echo '<td>' . RHtmlHelper::linkAction('user', $comment->user->name, 'view', $comment->user->id) . '</td>';
            echo '<td>' . $comment->createdTime . '</td>';
            if (mb_strlen($comment->content) > 140) {
                $comment->content = mb_substr($comment->content, 0, 140, 'UTF-8') . '...';
            }
            echo '<td>' . RHtmlHelper::linkAction('post', $comment->topic->title, 'view', $comment->topic->id) . '</td>';
            echo '<td>'. $comment->content . '</td>';
            echo '<td>'. RHtmlHelper::linkAction('post','View','view',$comment->topic->id.'#comment-item-'.$comment->id). '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
</div>
<?= RFormHelper::endForm() ?>

<?= $pager ?>
<?php
    //$ajax = new RAjaxHelper('ajax_delete_comment','Ajax delete',RHtmlHelper::siteUrl('comment/admin'),'POST',array('page'=>'1','pagesize'=>5),'before_delete','after_delete',array('class'=>'ajax_delete','title'=>'Ajax delete'));
    //echo $ajax->html();
?>