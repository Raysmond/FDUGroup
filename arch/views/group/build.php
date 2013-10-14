<?php

$form = array();
if(isset($buildForm))
    $form = $buildForm;

echo RFormHelper::openForm('group/build',array('id'=>'build-group-form','class'=>'form-signin build-group-form'));

echo RFormHelper::label('Group name','group-name',array());
echo RFormHelper::input(
    array('id'=>'group-name',
        'name'=>'group-name',
        'class'=>'form-control',
        'placeholder'=>'Group name',
    ),$form);

echo RFormHelper::label('Group Category','category',array());
echo RFormHelper::input(
    array('id'=>'category',
        'name'=>'category',
        'class'=>'form-control',
        'placeholder'=>'Group category',
    ),$form);

echo RFormHelper::label('Group Introduction','intro',array());
echo '<br/>';
echo RFormHelper::textarea(array('name'=>'intro','cols'=>'50','rows'=>'5'));

echo '<br/><br/>';
echo RFormHelper::input(
    array('class'=>'btn btn-lg btn-primary btn-block','type'=>'submit','value'=>'Build now'));


echo RFormHelper::endForm();