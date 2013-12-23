<div class="panel panel-default">

    <div class="panel-body">
        <?php
        if (isset($validation_errors)) {
            RHtml::showValidationErrors($validation_errors);
        }
        $form = array();
        if (isset($editForm))
            $form = $editForm;

        echo RForm::openForm('group/edit/' . $groupId, array('id' => 'edit-group-form',
                'enctype' => 'multipart/form-data', 'class' => 'build-group-form'));

        echo RForm::label('Group name', 'group-name', array());
        echo RForm::input(
            array('id' => 'group-name',
                'name' => 'group-name',
                'class' => 'form-control',
                'placeholder' => 'Group name',
            ), isset($group) ? $group->name : $form);

        echo "<br/>";
        echo RForm::label("Category:", 'category') . "&nbsp;&nbsp;";

        $catId = isset($group) ? $group->categoryId : $form['category'];
        $index = 0;
        $cats = array();
        $count = 0;
        foreach ($categories as $cat) {
            if ($cat->id == $catId) {
                $index = $count;
            }
            $count++;
            array_push($cats, array('value' => $cat->id, 'text' => $cat->name));
        }

        echo RForm::select('category', $cats, array($cats[$index]['value']), array('class' => 'form-control'));
        echo "<br/>";

        echo RForm::label('Group Introduction', 'intro', array());
        echo '<br/>';

        //echo RForm::textarea(array('class'=>'ckeditor','name'=>'intro','cols'=>'100','rows'=>'15'),
        //    isset($group)?RHtml::decode($group->intro):RHtml::decode($form));

        $formIntro = isset($form['intro']) ? $form['intro'] : '';
        $self->module('ckeditor',
            array('editorId' => 'intro',
                'name' => 'intro',
                'data' => (isset($group) ? $group->intro : $formIntro)
            ));

        echo '<br/>';

        if (isset($group)) {
            $picture = $group->picture ? $group->picture : Group::$defaults['picture'];
            echo RHtml::showImage(
                RImage::styleSrc($picture, Group::getPicOptions()),
                $group->name,
                array('class' => 'img-thumbnail', 'width' => '120px')
            );
        }

        echo '<br/>';

        echo RForm::label('New group picture', 'group_picture');
        echo RForm::input(array('type' => 'file', 'name' => 'group_picture', 'accept' => 'image/gif, image/jpeg,image/png'));

        echo '<br/>';
        echo RForm::input(
            array('class' => 'btn btn-lg btn-primary', 'type' => 'submit', 'value' => 'Save'));

        echo RForm::endForm();
        ?>
    </div>
</div>