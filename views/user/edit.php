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
            echo RHtml::showValidationErrors($validation_errors);
        }

        echo RForm::openForm('user/edit/'.$user->id,
            array('id' => 'user-edit-form', 'enctype' => 'multipart/form-data'));

        echo RForm::label("User name", 'username');
        echo RForm::input(
            array('id' => 'username',
                'name' => 'username',
                'class' => 'form-control',
                'value' => $user->name,
                'placeholder' => "Your username",
            ));

        // email cannot be changed.
        echo RForm::label("Email", 'mail');
        echo RForm::input(
            array('id' => 'mail',
                //'name'=>'mail',
                'class' => 'form-control',
                'value' => $user->mail,
                'placeholder' => "username@example.com",
                'readonly' => 'true'));


        echo RForm::label("New Password", 'password');
        echo RForm::input(
            array('id' => 'password',
                'name' => 'password',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => "New Password. Leave empty if you don't wanna change password."));

        echo RForm::label("Password confirm", 'password-confirm');
        echo RForm::input(
            array('id' => 'password-confirm',
                'name' => 'password-confirm',
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => "Password confirm"));

        echo RForm::label('Gender','gender');
        ?>

        <select name="gender" class="form-control">
            <option value="0" <?=($user->gender==0?"selected":"") ?>>Unknown</option>
            <option value="1" <?=($user->gender==1?"selected":"") ?>>Male</option>
            <option value="2" <?=($user->gender==2?"selected":"") ?>>Female</option>
        </select>

        <?php

        echo RForm::label("Region", 'region');
        echo RForm::input(
            array('id' => 'region',
                'name' => 'region',
                'class' => 'form-control',
                'value' => $user->region,
                'placeholder' => "region"));

        echo RForm::label("Mobile", 'mobile');
        echo RForm::input(
            array('id' => 'mobile',
                'name' => 'mobile',
                'class' => 'form-control',
                'value' => $user->mobile,
                'placeholder' => "Mobile"));

        echo RForm::label("QQ", 'qq');
        echo RForm::input(
            array('id' => 'qq',
                'name' => 'qq',
                'class' => 'form-control',
                'value' => $user->qq,
                'placeholder' => "QQ"));

        echo RForm::label("Weibo", 'weibo');
        echo RForm::input(
            array('id' => 'weibo',
                'name' => 'weibo',
                'class' => 'form-control',
                'value' => $user->weibo,
                'placeholder' => "Weibo"));

        echo RForm::label("Homepage", 'homepage');
        echo RForm::input(
            array('id' => 'homepage',
                'name' => 'homepage',
                'class' => 'form-control',
                'value' => $user->homepage,
                'placeholder' => "Homepage"));

        echo RForm::label("Introduction", 'intro');
        echo RForm::input(
            array('id' => 'intro',
                'name' => 'intro',
                'class' => 'form-control',
                'value' => $user->intro,
                'placeholder' => "your introduction"));

        echo RForm::label("Picture");
        echo '<br/>';
        if($user->picture){
            $picture = RImage::styleSrc($user->picture,User::getPicOptions());
            echo RHtml::image($picture,$user->name,array("width"=>'120px','class'=>'img-thumbnail'));
        }
        echo '<br/><br/>';
        echo RForm::input(array('type' => 'file', 'name' => 'user_picture', 'accept' => 'image/gif, image/jpeg,image/png'));
        echo "<br/>";

        echo RForm::input(array('type' => 'submit', 'value' => 'Complete', 'class' => "btn btn-lg btn-primary"));
        echo RForm::endForm();
        ?>
    </div>
</div>


