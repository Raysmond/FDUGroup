<?php
    Rays::css("/public/css/form.css");
?>
        <div class="panel panel-default user-login-register-panel">
            <div class="panel-heading"><b>Register</b></div>
            <div class="panel-body">
            <?php
                if(isset($validation_errors)){
                    RHtml::showValidationErrors($validation_errors);
                }
                $form = array();
                if(isset($registerForm)){
                    $form = $registerForm;
                }
                echo RForm::openForm('user/register',
                    array('id'=>'registerForm', 'class'=>'form-signin registerForm'));

                //echo RForm::label("User name",'username');
                echo RForm::input(
                    array('id'=>'username',
                        'name'=>'username',
                        'class'=>'form-control',
                        'placeholder'=>'User name',
                    ),$form);

                //echo RForm::label("Email",'email');
                echo RForm::input(
                    array('id'=>'email',
                        'name'=>'email',
                        'class'=>'form-control',
                        'placeholder'=>'email@host.com'),$form);

               // echo RForm::label("Password",'password');
                echo RForm::input(
                    array('id'=>'password',
                        'name'=>'password',
                        'type'=>'password',
                        'class'=>'form-control',
                        'placeholder'=>'Password'),$form);

               // echo RForm::label("Password confirm",'password-confirm');
                echo RForm::input(array(
                    'id'=>'password-confirm',
                    'name'=>'password-confirm',
                    'type'=>'password',
                    'class'=>'form-control',
                    'placeholder'=>'Password confirm'),$form);


                echo RForm::input(
                    array('class'=>'btn btn-primary','type'=>'submit','value'=>'Register'));
                echo RForm::endForm();
            ?>
            </div>
        </div>



