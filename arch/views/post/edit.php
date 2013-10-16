<h1>New topic</h1>
<?php
if ($type == "new") {
    $url = "post/new/$groupId";
    $title = '';
    $content = '';
    $submitText = "Post";
}
else {
    $url = "post/edit/$topic->id";
    $title = $topic->title;
    $content = $topic->content;
    $submitText = "Edit";
}
?>
<?=RFormHelper::openForm($url, array('id' => 'viewFrom', 'class' => '.form-signin registerForm'))?>
<?=RFormHelper::input(array(
    'id' => 'title',
    'name' => 'title',
    'class' => 'form-control',
    'placeholder' => 'Title'
), $title)?>
<br/>
<?=RFormHelper::textarea(array(
    'id' => 'content',
    'name' => 'content',
    'class' => 'form-control',
    'rows' => 15,
    'placeholder' => 'Content'
), $content)?>
<br/><br/>
<?=RFormHelper::input(array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit', 'value' => $submitText))?>
<?=RFormHelper::endForm()?>
