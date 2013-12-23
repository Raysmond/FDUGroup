<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 * Date: 13-10-16
 * Time: AM8:57
 * To change this template use File | Settings | File Templates.
 */

if(isset($validation_errors))
    RHtml::showValidationErrors($validation_errors);

$form = array();
if(isset($newForm))
    $form = $newForm;

echo RForm::openForm('category/new',
    array(
        'id'=>'new-category-form',
        'class'=>'new-category-form'));

echo '<h2>Create new category</h2>';

echo RForm::label("Category name",'name');
echo RForm::input(
    array('id'=>'name',
        'name'=>'name',
        'class'=>'form-control',
        'placeholder'=>'Category name',
    ),$form);

echo '<br/>';

echo RForm::label("Category parent",'parent');
echo RForm::input(
    array('id'=>'parent',
        'name'=>'parent',
        'class'=>'form-control',
        'placeholder'=>'Category parent',
    ),$form);

echo '<br/>';

echo RForm::input(array('type'=>'hidden','name'=>'id',), $form);

echo RForm::input(
    array(
        'class'=>'btn btn-lg btn-primary btn-block',
        'type'=>'submit',
        'value'=>'Save'));

echo RForm::endForm();
