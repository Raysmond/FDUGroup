<h1>New topic</h1>
<?php
if(isset($validation_errors)){
    RHtmlHelper::showValidationErrors($validation_errors);
}
$newForm = array();
if(isset($newPostForm))
    $newForm = $newPostForm;

if ($type == "new") {
    $url = "post/new/$groupId";
    $title = RFormHelper::setValue($newForm,'title');
    $content = RFormHelper::setValue($newForm,'content');
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
<?php if(isset($group)){
    echo 'In group: '.RHtmlHelper::linkAction('post',$group->name,'list',$group->id)."<br/><br/>";
} ?>
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
    'rows' => 14,
    'placeholder' => 'Content'
), $content)?>
<br/><br/>
<?=RFormHelper::input(array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit', 'value' => $submitText))?>
<?=RFormHelper::endForm()?>
