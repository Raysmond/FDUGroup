<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
?>
<div id="profile" class=" panel panel-default">
    <div class="panel-heading"><h1 class="panel-title">VIP application</h1></div>
    <div class="panel-body">
<?php
if(isset($validation_errors)){
    RHtmlHelper::showValidationErrors($validation_errors);
}
$form = array();
if(isset($sendForm))
    $form = $sendForm;

echo RFormHelper::openForm('user/applyVIP/',array('id'=>'vipApplyForm'));

echo RFormHelper::label('Statement of Purpose: ','content',array());
echo "<br/>";

echo RFormHelper::textarea(
    array('id'=>'content',
        'name'=>'content',
        'cols'=>100,
        'rows'=>6,
        'class'=>'form-control',
        'placeholder'=>'Explain your purpose and qualification of applying for VIP',
    ),$form);

echo "<br/>";

echo RFormHelper::input(array('type'=>'submit','value'=>'Send','class'=>'btn btn-lg btn-primary'));

echo RFormHelper::endForm();
?>
    </div>
</div>