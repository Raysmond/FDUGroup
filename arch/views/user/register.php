<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading"><b>Register</b></div>
            <div class="panel-body">
            <?php
                if(isset($validation_errors)){
                    RHtmlHelper::showValidationErrors($validation_errors);
                }
                $form = array();
                if(isset($registerForm)){
                    $form = $registerForm;
                }
                echo RFormHelper::openForm('user/register',
                    array('id'=>'registerForm', 'class'=>'form-signin registerForm'));

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
                    array('class'=>'btn btn-primary','type'=>'submit','value'=>'Register'));
                echo RFormHelper::endForm();
            ?>
            </div>
        </div>
    </div>
</div>


