<?php
if(isset($validation_errors)){
    RHtmlHelper::showValidationErrors($validation_errors);
}
$form = array();
if(isset($editForm))
    $form = $editForm;

echo RFormHelper::openForm('group/edit/'.$groupId,array('id'=>'edit-group-form',
    'enctype'=>'multipart/form-data','class'=>'form-signin build-group-form'));

echo RFormHelper::label('Group name','group-name',array());
echo RFormHelper::input(
    array('id'=>'group-name',
        'name'=>'group-name',
        'class'=>'form-control',
        'placeholder'=>'Group name',
    ),isset($group)?$group->name:$form);

echo "<br/>";
echo RFormHelper::label("Category:",'category')."&nbsp;&nbsp;";

$catId = isset($group)?$group->categoryId:$form['category'];
$index = 0;
$cats = array();
$count = 0;
foreach($categories as $cat){
    if($cat->id==$catId){
        $index = $count;
    }
    $count++;
    array_push($cats,array('value'=>$cat->id,'text'=>$cat->name));
}

echo RFormHelper::select('category',$cats,array($cats[$index]['value']),array('class'=>'form-control'));
echo "<br/>";

echo RFormHelper::label('Group Introduction','intro',array());
echo '<br/>';

//echo RFormHelper::textarea(array('class'=>'ckeditor','name'=>'intro','cols'=>'100','rows'=>'15'),
//    isset($group)?RHtmlHelper::decode($group->intro):RHtmlHelper::decode($form));

$formIntro = isset($form['intro'])?$form['intro']:'';
$this->module('ckeditor',
    array('editorId'=>'intro',
        'name'=>'intro',
        'data'=>(isset($group)?$group->intro:$formIntro)
    ));

echo '<br/>';
echo RFormHelper::label('New group picture','group_picture');
echo RFormHelper::input(array('type'=>'file','name'=>'group_picture','accept'=>'image/gif, image/jpeg,image/png'));

echo '<br/><br/>';
echo RFormHelper::input(
    array('class'=>'btn btn-lg btn-primary btn-block','type'=>'submit','value'=>'Save'));

echo RFormHelper::endForm();