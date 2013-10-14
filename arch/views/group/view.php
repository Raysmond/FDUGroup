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

    echo RHtmlHelper::linkAction('group','Build my group','build',null,array('class'=>'btn btn-success'));

    echo "<br/><br/>";

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
        echo "&nbsp;&nbsp;";
        echo RHtmlHelper::linkAction('group','Exit group','exit',$group->id);
        echo "&nbsp;&nbsp;";
        echo RHtmlHelper::linkAction('group','View details','detail',$group->id);
        echo '</td></div></tr>';
    }

    echo RFormHelper::endForm();
