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

echo "<br/>";
echo RFormHelper::label("Category:",'category')."&nbsp;&nbsp;";
$cats = array();
foreach($categories as $cat){
    array_push($cats,array('value'=>$cat->id,'text'=>$cat->name));
}
echo RFormHelper::select('category',$cats,array($cats[0]['value']));
echo "<br/>";

echo RFormHelper::label('Group Introduction','intro',array());
echo '<br/>';
echo RFormHelper::textarea(array('name'=>'intro','cols'=>'100','rows'=>'15'));

echo '<br/><br/>';
echo RFormHelper::input(
    array('class'=>'btn btn-lg btn-primary btn-block','type'=>'submit','value'=>'Build now'));


echo RFormHelper::endForm();