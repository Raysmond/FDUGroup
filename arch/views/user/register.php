<?php
    if(isset($validation_errors)){
        echo '<div class="alert alert-danger">';
        foreach($validation_errors as $error){
            foreach($error as $e)
                foreach($e as $one){
                    echo $one."<br/>";
                }
        }
        echo '</div>';
    }
    $form = array();
    if(isset($registerForm)){
        $form = $registerForm;
    }
    echo RFormHelper::openForm('user/register',
        array('id'=>'registerForm', 'class'=>'form-signin registerForm'));
    echo '<h2 class="form-signin-heading">Register</h2>';

    echo RFormHelper::label("User name",'username');
    echo RFormHelper::input(
        array('id'=>'username',
            'name'=>'username',
            'class'=>'form-control',
            'placeholder'=>'User name',
        ),$form);

    echo RFormHelper::label("Email",'email');
    echo RFormHelper::input(
        array('id'=>'email',
            'name'=>'email',
            'class'=>'form-control',
            'placeholder'=>'email@host.com'),$form);

    echo RFormHelper::label("Password",'password');
    echo RFormHelper::input(
        array('id'=>'password',
            'name'=>'password',
            'type'=>'password',
            'class'=>'form-control',
            'placeholder'=>'Password'),$form);

    echo RFormHelper::label("Password confirm",'password-confirm');
    echo RFormHelper::input(array(
        'id'=>'password-confirm',
        'name'=>'password-confirm',
        'type'=>'password',
        'class'=>'form-control',
        'placeholder'=>'Password confirm'),$form);

    echo "<br/>";

    echo RFormHelper::input(
        array('class'=>'btn btn-lg btn-primary btn-block','type'=>'submit','value'=>'Register'));
    echo RFormHelper::endForm();

