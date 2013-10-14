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



echo RFormHelper::openForm('user/useredit',
    array('id'=>'usereditForm', 'class'=>'.form-signin registerForm'));
echo '<h2 class="form-signin-heading">User Information Edit: </h2>';


echo RFormHelper::label("User name",'username');
echo RFormHelper::input(
    array('id'=>'username',
        'name'=>'username',
        'class'=>'form-control',
        'placeholder'=>$user->name,
    ));

echo RFormHelper::label("Email",'email');
echo RFormHelper::input(
    array('id'=>'email',
        'name'=>'email',
        'class'=>'form-control',
        'placeholder'=>$user->mail));

echo RFormHelper::label("Password",'password');
echo RFormHelper::input(
    array('id'=>'password',
        'name'=>'password',
        'type'=>'password',
        'class'=>'form-control',
        'placeholder'=>$user->password));

echo RFormHelper::label("Region",'region');
echo RFormHelper::input(
    array('id'=>'region',
        'name'=>'region',
        'class'=>'form-control',
        'placeholder'=>$user->region));

echo RFormHelper::label("Mobile",'mobile');
echo RFormHelper::input(
    array('id'=>'mobile',
        'name'=>'mobile',
        'class'=>'form-control',
        'placeholder'=>$user->mobile));

echo RFormHelper::label("QQ",'qq');
echo RFormHelper::input(
    array('id'=>'qq',
        'name'=>'qq',
        'class'=>'form-control',
        'placeholder'=>$user->qq));

echo RFormHelper::label("Weibo",'weibo');
echo RFormHelper::input(
    array('id'=>'weibo',
        'name'=>'weibo',
        'class'=>'form-control',
        'placeholder'=>$user->weibo));

echo RFormHelper::label("Introduction",'intro');
echo RFormHelper::input(
    array('id'=>'intro',
        'name'=>'intro',
        'class'=>'form-control',
        'placeholder'=>$user->intro));

echo "<br/>";

echo RFormHelper::button(
    array('class'=>'btn btn-lg btn-primary btn-block','type'=>'submit','value'=>'Edit Complete!'));
echo RFormHelper::endForm();

