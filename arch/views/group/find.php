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
echo '<div>';
    echo '<div class="row">';
    echo RFormHelper::openForm('group/find',
        array('id'=>'findFrom', 'class'=>'.form-signin registerForm'));
    echo '<h2 class="form-signin-heading">Find Groups</h2>';

    $groups = $data['group'];
    foreach($groups as $group){
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
    }
    echo RFormHelper::endForm();
    echo '</div>';

    echo '<ul class="pagination">';
    echo '<li><a href="'.RHtmlHelper::siteUrl('group/find').'">&laquo;</a></li>';

    $remain = $data['page_number'] - $data['page'];
    if($data['page'] < 3 && $remain <2){
        $start = 1; $end = $data['page_number']+1;
    }else if($data['page'] < 3 && $remain > 1){
        if($data['page_number'] > 5){
            $start = 1; $end = 6;
        }
        else{
            $start = 1; $end = $data['page_number']+1;
        }
    }else if($data['page'] >2 && $remain <2){
        if($data['page_number'] > 5){
            $start = $data['page_number']-4; $end = $data['page_number']+1;
        }
        else{
            $start = 1; $end = $data['page_number']+1;
        }
    }else{
        $start = $data['page']-2; $end = $data['page']+3;
    }
    for($index = $start; $index <  $end ; $index++)
        echo '<li><a href="'.RHtmlHelper::siteUrl('group/find/'.$index).'">'.$index.'</a></li>';
    echo '<li><a href="'.RHtmlHelper::siteUrl('group/find/'.$data['page_number'].'/'.$data['pagesize']).'">&raquo;</a></li>';
    echo '</ul>';
echo '</div>';