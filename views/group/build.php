<div class="panel panel-default">
    <div class="panel-heading"><h1 class="panel-title">Create a group</h1></div>
    <div class="panel-body">
<?php
if(isset($validation_errors)){
    RHtml::showValidationErrors($validation_errors);
}
$form = array();
if(isset($buildForm))
    $form = $buildForm;

echo RForm::openForm('group/build',array('id'=>'build-group-form',
    'enctype'=>'multipart/form-data','class'=>'build-group-form'));

echo RForm::label('Group name','group-name',array());
echo RForm::input(
    array('id'=>'group-name',
        'name'=>'group-name',
        'class'=>'form-control',
        'placeholder'=>'Group name',
    ),$form);

echo "<br/>";
//echo RForm::label("Category:",'category')."&nbsp;&nbsp;";

$cats = array();
foreach($categories as $cat){
    array_push($cats,array('value'=>$cat->id,'text'=>$cat->name));
}
?>
<div class="form-group">
    <label class="col-sm-2 control-label" style="padding-left: 0;">Category</label>
    <div class="col-sm-10">

        <select class="form-control" name="category">
            <?php
                $count = 0;
                foreach($categories as $item){
                    if($item->pid==0){
                        echo '<option value="'.$item->id.'" '.($count++==0?'selected="selected"':"").'>'.$item->name.'</option>';
                        foreach($categories as $item1){
                            if($item1->pid==$item->id){
                                echo '<option value="'.$item1->id.'">------'.$item1->name.'</option>';
                            }
                        }
                    }
                }
            ?>
        </select>
    </div>
</div>
<?php
//echo RForm::select('category',$cats,array($cats[0]['value']),array('class'=>'form-control'));
//echo "<br/>";

echo RForm::label('Group Introduction','intro',array());
echo '<br/>';
//echo RForm::textarea(array('id'=>'group_intro','class'=>'ckeditor','name'=>'intro','cols'=>'100','rows'=>'15'),(isset($form['intro']))?RHtml::decode($form['intro']):"");
$formIntro = isset($form['intro'])?$form['intro']:'';
$self->module('ckeditor',
    array('editorId'=>'intro',
        'name'=>'intro',
        'data'=>(isset($oldGroup)?$oldGroup->intro:$formIntro)
    ));
echo '<br/>';
echo RForm::label('Group picture','group_picture');
echo RForm::input(array('type'=>'file','name'=>'group_picture','accept'=>'image/gif, image/jpeg,image/png'));

echo '<br/>';
echo RForm::input(
    array('class'=>'btn btn-lg btn-primary','type'=>'submit','value'=>'Build now'));

echo RForm::endForm();
?>
    </div>
</div>