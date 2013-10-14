<?php
/**
 * User login view
 * @author: Raysmond
 */

if(isset($validation_errors)){
    RHtmlHelper::showValidationErrors($validation_errors);
}
$form = array();
if(isset($loginForm)){
    $form = $loginForm;
}
echo RFormHelper::openForm('user/login',
    array('id'=>'loginForm', 'class'=>'form-signin login-form'));
echo '<h2 class="form-signin-heading">Login</h2>';

echo RFormHelper::label("User name",'username');
echo RFormHelper::input(
    array('id'=>'username',
        'name'=>'username',
        'class'=>'form-control',
        'placeholder'=>'User name',
    ),$form);

echo RFormHelper::label("Password",'password');
echo RFormHelper::input(
    array('id'=>'password',
        'name'=>'password',
        'type'=>'password',
        'class'=>'form-control',
        'placeholder'=>'Password',
    ),$form);

echo RFormHelper::input(
    array('class'=>'btn btn-lg btn-primary btn-block','type'=>'submit','value'=>'Login'));
echo RFormHelper::endForm();
?>
