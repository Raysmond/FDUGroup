<?php
/**
 * User login view
 * @author: Raysmond
 */
?>
<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="panel panel-default user-login-register-panel">
            <div class="panel-heading"><b>Sign in</b></div>
            <div class="panel-body">
                <?php
                if(isset($validation_errors)){
                    RHtmlHelper::showValidationErrors($validation_errors);
                }
                $form = array();
                if(isset($loginForm)){
                    $form = $loginForm;
                }
                echo RFormHelper::openForm('user/login',
                    array('id'=>'loginForm', 'class'=>'form-signin login-form'));
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
                    array('class'=>'btn btn-primary','type'=>'submit','value'=>'Login'));
                echo RFormHelper::endForm();
                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6"></div>
</div>


