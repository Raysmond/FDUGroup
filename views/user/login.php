
        <div class="panel panel-default user-login-register-panel">
            <div class="panel-heading"><b>Sign in</b></div>
            <div class="panel-body">
                <?php
                if(isset($validation_errors)){
                    RHtml::showValidationErrors($validation_errors);
                }
                $form = array();
                if(isset($loginForm)){
                    $form = $loginForm;
                }
                echo RForm::openForm('user/login',
                    array('id'=>'loginForm', 'class'=>'form-signin login-form'));
                //echo RForm::label("User name",'username');
                echo RForm::hidden('returnURL', Rays::referrerUri()?:"");
                echo RForm::input(
                    array('id'=>'username',
                        'name'=>'username',
                        'class'=>'form-control',
                        'placeholder'=>'User name',
                    ),$form);

                //echo RForm::label("Password",'password');
                echo RForm::input(
                    array('id'=>'password',
                        'name'=>'password',
                        'type'=>'password',
                        'class'=>'form-control',
                        'placeholder'=>'Password',
                    ),$form);
                echo RForm::input(
                    array('class'=>'btn btn-primary','type'=>'submit','value'=>'Login'));
                echo RForm::endForm();
                ?>
            </div>
        </div>



