<?php
/**
 * show my groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:53
 */
    $form = array();
    if(isset($registerForm)){
        $form = $registerForm;
    }
    echo RFormHelper::openForm('group/view',
        array('id'=>'viewFrom', 'class'=>'.form-signin registerForm'));

    echo RFormHelper::button(array('type'=>'submit','class'=>'btn btn-success'),'Build My Group Now!');
    if($data == null){
        echo "<p>You have not joint any groups!</p>";
        return null;
    }

    foreach($data as $group){
        echo '<tr><div class="alert alert-success">';
        echo "<td>";
        foreach($group->columns as $col=>$coldb){
            if(isset($group->$col))
                echo RFormHelper::label($group->$col)."      ";
        }
        echo "</td><td>";
        echo RFormHelper::button(array('type'=>'submit','class'=>'btn btn-success'),'Exit Group');
        echo '</td></div></tr>';
    }

    echo RFormHelper::endForm();
