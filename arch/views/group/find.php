<?php
/**
 * show all groups
 * Author: Guo Junshi
 * Date: 13-10-14
 * Time: 下午1:52
 */
    $form = array();
    if(isset($searchForm)){
        $form = $searchForm;
    }
    $lastSearchStr = isset($searchstr)?$searchstr:"";
    if($lastSearchStr!='')
        $lastSearchStr = urlencode($lastSearchStr);
echo '<div>';

    echo '<h2 class="form-signin-heading">Find Groups</h2>';
    echo '<div class="navbar-right" style="position: absolute;top:25px;">';
    echo RFormHelper::openForm('group/find',array('class'=>'form-signin find-group-form'));
    //echo RFormHelper::input(array("id"=>'searchstr',"name"=>'searchstr','class'=>'form-control',"placeholder"=>'Search group'));
    //echo RFormHelper::input(array('type'=>'submit','value'=>'Search','class'=>'btn btn-success'));

    echo '<div class="col-lg-6" style="float:right;">
    <div class="input-group">
      <input type="text" class="form-control" name="searchstr" value="'.urldecode($lastSearchStr).'" placeholder="Search Groups">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit">Go!</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->';

    echo RFormHelper::endForm();
    echo '</div>';
    echo '<div class="clearfix" style="margin-bottom: 10px;"></div>';

echo '<div class="row">';
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
    echo '</div>';

    echo '<ul class="pagination">';
    echo '<li><a href="'.RHtmlHelper::siteUrl('group/find/1/'.$lastSearchStr).'">&laquo;</a></li>';

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
        echo '<li><a href="'.RHtmlHelper::siteUrl('group/find/'.$index.'/'.$lastSearchStr).'">'.$index.'</a></li>';
    echo '<li><a href="'.RHtmlHelper::siteUrl('group/find/'.$data['page_number'].'/'.$lastSearchStr).'">&raquo;</a></li>';
    echo '</ul>';
echo '</div>';