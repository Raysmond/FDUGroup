<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yizhou
 * Date: 13-10-14
 * Time: 下午6:57
 * To change this template use File | Settings | File Templates.
 */
?>
<?php
$form = array();
if(isset($editForm))
    $form = $editForm;

if(isset($validation_errors)){
    echo RHtmlHelper::showValidationErrors($validation_errors);
}

echo RFormHelper::openForm('user/edit/',
    array('id'=>'user-edit-form', 'enctype'=>'multipart/form-data','class'=>'.form-signin'));
echo '<h2 class="form-signin-heading">User Information Edit: </h2>';

echo RFormHelper::label("User name",'username');
echo RFormHelper::input(
    array('id'=>'username',
        'name'=>'username',
        'class'=>'form-control',
        'value'=>$user->name,
        'placeholder'=>"Your username",
    ));

// email cannot be changed.
echo RFormHelper::label("Email",'mail');
echo RFormHelper::input(
    array('id'=>'mail',
        //'name'=>'mail',
        'class'=>'form-control',
        'value'=>$user->mail,
        'placeholder'=>"username@example.com",
        'readonly'=>'true'));


echo RFormHelper::label("New Password",'password');
echo RFormHelper::input(
    array('id'=>'password',
        'name'=>'password',
        'type'=>'password',
        'class'=>'form-control',
        'placeholder'=>"New Password. Leave empty if you don't wanna change password."));

echo RFormHelper::label("Password confirm",'password-confirm');
echo RFormHelper::input(
    array('id'=>'password-confirm',
        'name'=>'password-confrim',
        'type'=>'password',
        'class'=>'form-control',
        'placeholder'=>"Password confirm"));

echo RFormHelper::label("Region",'region');
echo RFormHelper::input(
    array('id'=>'region',
        'name'=>'region',
        'class'=>'form-control',
        'value'=>$user->region,
        'placeholder'=>"region"));

echo RFormHelper::label("Mobile",'mobile');
echo RFormHelper::input(
    array('id'=>'mobile',
        'name'=>'mobile',
        'class'=>'form-control',
        'value'=>$user->mobile,
        'placeholder'=>"Mobile"));

echo RFormHelper::label("QQ",'qq');
echo RFormHelper::input(
    array('id'=>'qq',
        'name'=>'qq',
        'class'=>'form-control',
        'value'=>$user->qq,
        'placeholder'=>"QQ"));

echo RFormHelper::label("Weibo",'weibo');
echo RFormHelper::input(
    array('id'=>'weibo',
        'name'=>'weibo',
        'class'=>'form-control',
        'value'=>$user->weibo,
        'placeholder'=>"Weibo"));

echo RFormHelper::label("Homepage",'homepage');
echo RFormHelper::input(
    array('id'=>'homepage',
        'name'=>'homepage',
        'class'=>'form-control',
        'value'=>$user->homepage,
        'placeholder'=>"Homepage"));

echo RFormHelper::label("Introduction",'intro');
echo RFormHelper::input(
    array('id'=>'intro',
        'name'=>'intro',
        'class'=>'form-control',
        'value'=>$user->intro,
        'placeholder'=>"your introduction"));

echo RFormHelper::label("Picture");
echo RFormHelper::input(array('type'=>'file','name'=>'user_picture','accept'=>'image/gif, image/jpeg,image/png'));
echo "<br/>";

$this->module('ckeditor',array('id'=>'ckeditor','editorId'=>'user_edit_intro'));

echo RFormHelper::input(array('type'=>'submit','value'=>'Complete edit','class'=>"btn btn-lg btn-primary btn-block"));
echo RFormHelper::endForm();

