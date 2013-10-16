<p><b>New topic</b></p>
<?php
if ($type == "new") {
    $url = "post/new/$groupId";
    $content = '';
    $submitText = "Post";
}
else {
    $url = "post/edit/$topic->id";
    $content = $topic->content;
    $submitText = "Edit";
}
?>
<?=RFormHelper::openForm($url, array('id'=>'viewFrom', 'class'=>'.form-signin registerForm'))?>
<?=RFormHelper::input("title", "title")?>
<br/><br/>
<?=RFormHelper::textarea("content", $content)?>
<br/><br/>
<?=RFormHelper::input(array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit', 'value' => $submitText))?>
<?=RFormHelper::endForm()?>
