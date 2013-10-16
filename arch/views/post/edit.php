<p><b>New topic</b></p>
<?php
echo RFormHelper::openForm("post/new/$groupId",
    array('id'=>'viewFrom', 'class'=>'.form-signin registerForm'));

echo RFormHelper::input("title", "title");
echo "<br/><br/>";

echo RFormHelper::textarea("content", "asdf");
echo "<br/><br/>";

echo RFormHelper::input(array('class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit', 'value' => 'Post'));

echo RFormHelper::endForm();
?>
