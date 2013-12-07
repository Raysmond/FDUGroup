<div class="panel panel-default">

    <div class="panel-heading">
        <h1 class="panel-title">
            New topic
        </h1>
    </div>

    <div class="panel-body">

        <?php
        if(isset($validation_errors)){
            RHtmlHelper::showValidationErrors($validation_errors);
        }
        $newForm = array();
        if(isset($newPostForm))
            $newForm = $newPostForm;

        if ($type == "new") {
            $url = "post/new/$groupId";
            $title = RFormHelper::setValue($newForm,'title');
            $content = RHtmlHelper::decode(RFormHelper::setValue($newForm,'content'));
            $submitText = "Post";
        }
        else {
            $url = "post/edit/$topic->id";
            $title = $topic->title;
            $content = RHtmlHelper::decode($topic->content);
            $submitText = "Edit";
        }
        ?>
        <?=RFormHelper::openForm($url, array('id' => 'viewFrom'))?>

        <div class="form-group">
            <label class="col-sm-2 control-label" style="padding-left: 0;">Group</label>
            <div class="col-sm-10">
                <?php
                $values = array();
                foreach($groups as $item){
                    $values[] = ['value'=>$item->id,'text'=>$item->name];
                }
                $selected_value = $values[0]['value'];
                if(isset($newForm['group'])){
                    $selected_value = $newForm['group'];
                }
                else if(isset($groupId)){
                    $selected_value = $groupId;
                }

                echo RFormHelper::select('group',$values,array($selected_value),array('class'=>'form-control'));
                ?>
            </div>
        </div>

        <br/><br/>

        <?=RFormHelper::input(array(
            'id' => 'title',
            'name' => 'title',
            'class' => 'form-control',
            'placeholder' => 'Title'
        ), $title)?>
        <br/>

        <?php
        /*
            echo RFormHelper::textarea(array(
                'id' => 'post-content',
                'name' => 'post-content',
                'class' => 'ckeditor form-control',
                'rows' => 14,
                'placeholder' => 'Content'
            ), $content);
         */

        $this->module('ckeditor',
            array('editorId'=>'post-content',
                'name'=>'content',
                'data'=>$content
            ));
        ?>


        <br/>
        <?=RFormHelper::input(array('class' => 'btn btn-lg btn-primary', 'type' => 'submit', 'value' => $submitText))?>
        <?=RFormHelper::endForm()?>
    </div>

</div>