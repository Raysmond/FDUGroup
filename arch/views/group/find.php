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
        echo '<div class="col-6 col-sm-6 col-lg-4" style="height: 190px;">';
        echo "<div class='panel panel-default' style='height: 170px;'>";
        echo "<div class='panel-heading'>";
        echo RHtmlHelper::linkAction('group',$group->name,'detail',$group->id);
        echo "</div>";
        echo "<div class='panel-body'>";
        echo $group->memberCount." members";
        if(strlen($group->intro)>100){
            echo '<p>'.substr($group->intro,0,100).'...</p>';
        }
        else echo '<p>'.$group->intro.'</p>';

        if(Rays::app()->isUserLogin()){
            $g_u = new GroupUser();
            $g_u->userId = Rays::app()->getLoginUser()->id;
            $g_u->groupId = $group->id;
            if(count($g_u->find())==0){
                echo RHtmlHelper::linkAction('group','+ Join the group','join',$group->id,
                    array('class'=>'btn btn-xs btn-info','style'=>'position:absolute;top:135px;'));
            }else{
                echo RHtmlHelper::linkAction('group','- Exit group','exit',$group->id,
                    array('class'=>'btn btn-xs btn-info','style'=>'position:absolute;top:135px;'));
            }
        }else{
            echo RHtmlHelper::linkAction('group','+ Join the group','join',$group->id,
                array('class'=>'btn btn-xs btn-info','style'=>'position:absolute;top:135px;'));
        }

        echo "</div></div></div>";
        $flag = ($flag+1)%3;
    }
    echo "</div>";
    echo RFormHelper::endForm();
