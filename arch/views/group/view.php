<?php
/**
 * show my groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:53
 */
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
        echo '<p><b>'.RHtmlHelper::linkAction('post', $group->name, 'list', $group->id).'</b></p>';
        echo $group->memberCount." members";
        if(strlen($group->intro)>100){
            echo '<p>'.substr($group->intro,0,100).'...</p>';
        }
        else echo '<p>'.$group->intro.'</p>';
        echo "</td><td>";
        echo "&nbsp;&nbsp;";
        echo RHtmlHelper::linkAction('group','Exit group','exit',$group->id);
        echo "&nbsp;&nbsp;";
        echo RHtmlHelper::linkAction('group','View details','detail',$group->id);
        echo '</td></div></tr>';
    }

    echo RFormHelper::endForm();
