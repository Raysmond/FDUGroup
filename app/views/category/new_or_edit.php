<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 * Date: 13-10-16
 * Time: AM8:57
 * To change this template use File | Settings | File Templates.
 */

if(isset($validation_errors))
    RHtmlHelper::showValidationErrors($validation_errors);

$form = array();
if(isset($newForm))
    $form = $newForm;

echo RFormHelper::openForm('category/new',
    array(
        'id'=>'new-category-form',
        'class'=>'new-category-form'));

echo '<h2>Create new category</h2>';

echo RFormHelper::label("Category name",'name');
echo RFormHelper::input(
    array('id'=>'name',
        'name'=>'name',
        'class'=>'form-control',
        'placeholder'=>'Category name',
    ),$form);

echo '<br/>';

echo RFormHelper::label("Category parent",'parent');
echo RFormHelper::input(
    array('id'=>'parent',
        'name'=>'parent',
        'class'=>'form-control',
        'placeholder'=>'Category parent',
    ),$form);

echo '<br/>';

echo RFormHelper::input(array('type'=>'hidden','name'=>'id',), $form);

echo RFormHelper::input(
    array(
        'class'=>'btn btn-lg btn-primary btn-block',
        'type'=>'submit',
        'value'=>'Save'));

echo RFormHelper::endForm();
