<div class="panel panel-default">
    <div class="panel-heading"><h1 class="panel-title">Send Message</h1></div>
    <div class="panel-body">
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 * Date: 13-10-15
 * Time: PM3:32
 * To change this template use File | Settings | File Templates.
 */
        if(isset($validation_errors)){
            RHtml::showValidationErrors($validation_errors);
        }
        $form = array();
        if(isset($sendForm))
            $form = $sendForm;

        echo RForm::openForm('message/send/'.$type.'/',array('id'=>'messageForm','class'=>'form-signin'));

        echo RForm::label('To user: ','receiver',array());
        echo '&nbsp;&nbsp;';
        $disabled = isset($toUser)?"disabled":"enabled";
        echo RForm::input(
            array('id'=>'receiver',
                'name'=>'receiver',
                'class'=>'form-control',
                'placeholder'=>'Receiver',
            ), isset($toUser)?$toUser->name : $form);

        echo '<br/>';

        echo RForm::label('Title','title',array());
        echo RForm::input(
            array('id'=>'title',
                'name'=>'title',
                'class'=>'form-control',
                'placeholder'=>'Title',
            ),$form);

        echo "<br/>";

        echo RForm::label('Content','content',array());
        echo "<br/>";

        if(Rays::user()->roleId==Role::ADMINISTRATOR_ID){
            $self->module('ckeditor',
                array('editorId'=>'msg-content',
                    'name'=>'msg-content',
                    'data'=>(isset($form['content'])?$form['content']:'')
                ));
        }
        else{
            echo RForm::textarea(
                array('id'=>'msg-content',
                    'name'=>'msg-content',
                    'class'=>'form-control',
                    'cols'=>100,
                    'rows'=>6,
                    'placeholder'=>'Content',
                ),$form);
        }


        echo "<br/>";

        echo RForm::input(array('type'=>'hidden','value'=>$type,'name'=>'type'),$type);
        echo RForm::input(array('type'=>'submit','value'=>'Send','class'=>'btn btn-lg btn-primary'));

        echo RForm::endForm();
?>
    </div>
</div>