<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
?>
<div id="profile" class="panel panel-default">
    <div class="panel-heading"><h1 class="panel-title">VIP application</h1></div>
    <div class="panel-body">
        <?php
        if (isset($validation_errors)) {
            RHtml::showValidationErrors($validation_errors);
        }
        $form = array();
        if (isset($editForm))
            $form = $editForm;

        echo RForm::openForm('user/applyVIP/', array('id' => 'vipApplyForm'));

        echo RForm::label('Statement of Purpose: ', 'content', array());
        echo "<br/>";

        echo RForm::textarea(
            array('id' => 'content',
                'name' => 'content',
                'cols' => 100,
                'rows' => 6,
                'class' => 'form-control',
                'placeholder' => 'Explain your purpose and qualification of applying for VIP',
            ), $form);

        echo "<br/>";

        echo RForm::input(array('type' => 'submit', 'value' => 'Send', 'class' => 'btn btn-lg btn-primary'));

        echo RForm::endForm();
        ?>
    </div>
</div>