<?=RHtmlHelper::linkAction('post', 'Post new', 'new', $groupId, array('class' => 'btn btn-success'))?>
<br/><br/>
<?php
if ($topics == null) {
    ?><p>No topics.</p><?php
    return null;
}

?>
<table class="table">
<thead><tr><th>Title</th><th>Time</th><th>Last comment</th></tr></thead>
<tbody><?php

foreach ($topics as $topic) {
?><tr><td><b><?=RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id)?></b></td>
<td><?=$topic->createdTime?></td>
<td><?=$topic->lastCommentTime?></td></tr><?php
}

?></tbody></table>
