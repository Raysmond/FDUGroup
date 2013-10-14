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

echo RFormHelper::select('category1',array(
    array('value'=>"1","text"=>"tx2",'attributes'=>array('class'=>"asdlfkajsd")),array('value'=>"2","text"=>'text2'))
,array(),array('class'=>'myselectclass'));

echo RFormHelper::label('Group Introduction','intro',array());
echo '<br/>';
echo RFormHelper::textarea(array('name'=>'intro','cols'=>'100','rows'=>'15'));

echo '<br/><br/>';
echo RFormHelper::input(
    array('class'=>'btn btn-lg btn-primary btn-block','type'=>'submit','value'=>'Build now'));


echo RFormHelper::endForm();