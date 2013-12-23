<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-11-24
 * Time: PM3:33
 */
?>
<?=RForm::openForm('category/admin',array('id'=>'categoryAdminForm'))?>
<div class="panel panel-default">
    <div class="panel-heading">
        <b>Category administration</b>
        <div class="navbar-right">
            <?=RForm::input(array('type'=>'submit','value'=>'Delete','class'=>'btn btn-xs btn-danger'))?>
        </div>
    </div>
    <div class="panel-body">
        <div class="list-group">
            <?php
            foreach($categories as $category){
                if($category->pid!=0)
                    continue;
                echo '<li class="list-group-item">';
                echo '<a href="javascript:markCategoryParent(\''.$category->id.'\')" class="btn btn-xs btn-info">+</a>';
                echo " • <b>".RHtml::linkAction('category',$category->name,'groups',$category->id,array('id'=>'category-item-'.$category->id));
                echo '</b>&nbsp;&nbsp;';
                $subCategories = array();
                foreach($categories as $item){
                    if($item->pid==$category->id){
                        $subCategories[] = $item;
                    }
                }
                foreach($subCategories as $cat){
                    echo RForm::input(array('name'=>'sub_items[]','type'=>'checkbox','value'=>$cat->id));
                    echo '&nbsp;';
                    echo RHtml::linkAction('category',$cat->name,'groups',$cat->id)."  ";
                }
                echo '<br/>';
                echo '</li>';
            }
            ?>
        </div>
    </div>
</div>
<?=RForm::endForm()?>

<div class="panel panel-default">
    <div class="panel-heading"><b>Add category</b></div>
    <div class="panel-body">
        <?php
        $form = array();
        if (isset($addForm)) $form = $addForm;
        ?>
        <?= RForm::openForm('category/admin', array()) ?>
        <?= RForm::label('Category parent') ?>
        <?=RForm::input(array('type'=>'hidden','name'=>'parent-id','id'=>'parent-id'))?>
        <?=RForm::input(array('id'=>'parent-name','name'=>'parent-name','readonly'=>'true','class'=>'form-control'))?>
        <?= RForm::label('Name', 'cat-name') ?>
        <?= RForm::input(array('name' => 'cat-name', 'class' => 'form-control'), $form) ?>
        <br/>
        <?= RForm::input(array('type' => 'submit', 'value' => '+ Add', 'class' => 'btn btn-sm btn-success')) ?>
        <?= RForm::endForm() ?>
    </div>
</div>

<script>
    function markCategoryParent(pid){
        $("#parent-id").val(pid);
        $("#parent-name").val($("#category-item-"+pid).text());
    }
</script>