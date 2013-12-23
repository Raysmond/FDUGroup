<div class="panel panel-default">

    <div class="panel-heading">
        <div class="heading-actions">
            <?php if($type=='edit')
                echo RHtml::linkAction(
                    'post','Delete','delete',$topic->id.'?returnUrl='.RHtml::siteUrl('user/myposts'),
                    array(
                        'class'=>'btn btn-xs btn-danger',
                        'onclick'=>'return confirm("Are you sure to delete this topic? This operation cannot be undo!!!")'
                    ));
            ?>
        </div>
        <h1 class="panel-title">
            <?=$type=='edit'?$topic->title:"New post"?>
        </h1>
    </div>

    <div class="panel-body">

        <?php
        if(isset($validation_errors)){
            RHtml::showValidationErrors($validation_errors);
        }
        $newForm = array();
        if(isset($newPostForm))
            $newForm = $newPostForm;

        if ($type == "new") {
            $url = "post/new/$groupId";
            $title = RForm::setValue($newForm,'title');
            $content = RHtml::decode(RForm::setValue($newForm,'content'));
            $submitText = "Post";
        }
        else {
            $url = "post/edit/$topic->id";
            $title = $topic->title;
            $content = RHtml::decode($topic->content);
            $submitText = "Edit";
        }
        ?>
        <?=RForm::openForm($url, array('id' => 'viewFrom'))?>

        <div class="form-group">
            <label class="col-sm-2 control-label" style="padding-left: 0;">Group</label>
            <div class="col-sm-10">
                <?php
                $values = array();
                foreach($groups as $item){
                    $values[] = ['value'=>$item->id,'text'=>$item->name];
                }
                $canCreate = true;
                if(!empty($values)){
                    $selected_value = $values[0]['value'];
                    if(isset($newForm['group'])){
                        $selected_value = $newForm['group'];
                    }
                    else if(isset($groupId)){
                        $selected_value = $groupId;
                    }

                    echo RForm::select('group',$values,array($selected_value),array('class'=>'form-control'));
                }
                else{
                    $canCreate = false;
                    echo "You haven't joined any groups. Go ".RHtml::linkAction('group','find','find')." some and join them!";
                }

                ?>
            </div>
        </div>

        <br/><br/>

        <?php if($canCreate): ?>
        <?=RForm::input(array(
            'id' => 'title',
            'name' => 'title',
            'class' => 'form-control',
            'placeholder' => 'Title'
        ), $title)?>
        <br/>

        <?php
        /*
            echo RForm::textarea(array(
                'id' => 'post-content',
                'name' => 'post-content',
                'class' => 'ckeditor form-control',
                'rows' => 14,
                'placeholder' => 'Content'
            ), $content);
         */

        $self->module('ckeditor',
            array('editorId'=>'post-content',
                'name'=>'content',
                'data'=>$content
            ));
        ?>


        <br/>
        <?=RForm::input(array('class' => 'btn btn-lg btn-primary', 'type' => 'submit', 'value' => $submitText))?>

        <?php endif; ?>
        <?=RForm::endForm()?>
    </div>

</div>