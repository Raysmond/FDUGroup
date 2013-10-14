<?php
/**
 * show all groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:52
 */
    $form = array();
    if(isset($registerForm)){
        $form = $registerForm;
    }
    echo RFormHelper::openForm('group/find',
        array('id'=>'findFrom', 'class'=>'.form-signin registerForm'));
    echo '<h2 class="form-signin-heading">Find Groups</h2>';

    $flag = 0; $isFirstRow = 1;
    foreach($data as $group){
        if($flag == 0) {
            if($isFirstRow){
                $isFirstRow = 0;
                echo '<div class="row">';
            }
            else
                echo '</div><div class="row">';
        }
        echo "<div class='panel panel-default'>";
        echo "<div class='panel-heading'>";
        echo RFormHelper::label($group->name);
        echo '&nbsp;&nbsp;';
        echo RHtmlHelper::linkAction('group','Join','join',$group->id);
        echo '&nbsp;&nbsp;';
        echo RHtmlHelper::linkAction('group','View details','detail',$group->id);
        echo "</div>";
        echo "<div class='panel-body'>";
        foreach($group->columns as $col=>$coldb){
            if(isset($group->$col))
                echo RFormHelper::label($group->$col)."      ";
        }
        echo "</div></div>";
        $flag = ($flag+1)%3;
    }
    echo "</div>";
    echo RFormHelper::endForm();
