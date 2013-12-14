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
            RHtmlHelper::showValidationErrors($validation_errors);
        }
        $form = array();
        if(isset($sendForm))
            $form = $sendForm;

        echo RFormHelper::openForm('message/send/'.$type.'/',array('id'=>'messageForm','class'=>'form-signin'));

        echo RFormHelper::label('To user: ','receiver',array());
        echo '&nbsp;&nbsp;';
        $disabled = isset($toUser)?"disabled":"enabled";
        echo RFormHelper::input(
            array('id'=>'receiver',
                'name'=>'receiver',
                'class'=>'form-control',
                'placeholder'=>'Receiver',
            ), isset($toUser)?$toUser->name : $form);

        echo '<br/>';

        echo RFormHelper::label('Title','title',array());
        echo RFormHelper::input(
            array('id'=>'title',
                'name'=>'title',
                'class'=>'form-control',
                'placeholder'=>'Title',
            ),$form);

        echo "<br/>";

        echo RFormHelper::label('Content','content',array());
        echo "<br/>";

        if(Rays::app()->getLoginUser()->roleId==Role::ADMINISTRATOR_ID){
            $this->module('ckeditor',
                array('editorId'=>'msg-content',
                    'name'=>'msg-content',
                    'data'=>(isset($form['content'])?$form['content']:'')
                ));
        }
        else{
            echo RFormHelper::textarea(
                array('id'=>'msg-content',
                    'name'=>'msg-content',
                    'class'=>'form-control',
                    'cols'=>100,
                    'rows'=>6,
                    'placeholder'=>'Content',
                ),$form);
        }


        echo "<br/>";

        echo RFormHelper::input(array('type'=>'hidden','value'=>$type,'name'=>'type'),$type);
        echo RFormHelper::input(array('type'=>'submit','value'=>'Send','class'=>'btn btn-lg btn-primary'));

        echo RFormHelper::endForm();
?>
    </div>
</div>