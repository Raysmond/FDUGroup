<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yizhou
 */
?>
<div class="panel panel-default">
    <div class="panel-heading"><h1 class="panel-title">Edit profile: <?=$user->name?></h1></div>
    <div class="panel-body">
        <?php
        $form = array();
        if (isset($editForm))
            $form = $editForm;

        if (isset($validation_errors)) {
            echo RHtmlHelper::showValidationErrors($validation_errors);
        }

        echo RFormHelper::openForm('user/edit/',
            array('id' => 'user-edit-form', 'enctype' => 'multipart/form-data'));

        echo RFormHelper::label("User name", 'username');
        echo RFormHelper::input(
            array('id' => 'username',
                'name' => 'username',
                'class' => 'form-control',
                'value' => $user->name,
                'placeholder' => "Your username",
            ));

        // email cannot be changed.
        echo RFormHelper::label("Email", 'mail');
        echo RFormHelper::input(
            array('id' => 'mail',
                //'name'=>'mail',
                'class' => 'form-control',
                'value' => $user->mail,
                'placeholder' => "username@example.com",
                'readonly' => 'true'));


        echo RFormHelper::label("New Password", 'password');
        echo RFormHelper::input(
            array('id' => 'password',
                'name' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => "New Password. Leave empty if you don't wanna change password."));

        echo RFormHelper::label("Password confirm", 'password-confirm');
        echo RFormHelper::input(
            array('id' => 'password-confirm',
                'name' => 'password-confirm',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => "Password confirm"));

        echo RFormHelper::label('Gender','gender');
        ?>

        <select name="gender" class="form-control">
            <option value="0" <?=($user->gender==0?"selected":"") ?>>Unknown</option>
            <option value="1" <?=($user->gender==1?"selected":"") ?>>Male</option>
            <option value="2" <?=($user->gender==2?"selected":"") ?>>Female</option>
        </select>

        <?php

        echo RFormHelper::label("Region", 'region');
        echo RFormHelper::input(
            array('id' => 'region',
                'name' => 'region',
                'class' => 'form-control',
                'value' => $user->region,
                'placeholder' => "region"));

        echo RFormHelper::label("Mobile", 'mobile');
        echo RFormHelper::input(
            array('id' => 'mobile',
                'name' => 'mobile',
                'class' => 'form-control',
                'value' => $user->mobile,
                'placeholder' => "Mobile"));

        echo RFormHelper::label("QQ", 'qq');
        echo RFormHelper::input(
            array('id' => 'qq',
                'name' => 'qq',
                'class' => 'form-control',
                'value' => $user->qq,
                'placeholder' => "QQ"));

        echo RFormHelper::label("Weibo", 'weibo');
        echo RFormHelper::input(
            array('id' => 'weibo',
                'name' => 'weibo',
                'class' => 'form-control',
                'value' => $user->weibo,
                'placeholder' => "Weibo"));

        echo RFormHelper::label("Homepage", 'homepage');
        echo RFormHelper::input(
            array('id' => 'homepage',
                'name' => 'homepage',
                'class' => 'form-control',
                'value' => $user->homepage,
                'placeholder' => "Homepage"));

        echo RFormHelper::label("Introduction", 'intro');
        echo RFormHelper::input(
            array('id' => 'intro',
                'name' => 'intro',
                'class' => 'form-control',
                'value' => $user->intro,
                'placeholder' => "your introduction"));

        echo RFormHelper::label("Picture");
        echo '<br/>';
        if($user->picture){
            $picture = RImageHelper::styleSrc($user->picture,User::getPicOptions());
            echo RHtmlHelper::showImage($picture,$user->name,array("width"=>'120px','class'=>'img-thumbnail'));
        }
        echo '<br/><br/>';
        echo RFormHelper::input(array('type' => 'file', 'name' => 'user_picture', 'accept' => 'image/gif, image/jpeg,image/png'));
        echo "<br/>";

        echo RFormHelper::input(array('type' => 'submit', 'value' => 'Complete', 'class' => "btn btn-lg btn-primary"));
        echo RFormHelper::endForm();
        ?>
    </div>
</div>


