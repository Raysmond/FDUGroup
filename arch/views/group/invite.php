<?php
/** invite friends to join the group 'i' created... */
?>
<h2>
    <?= $group->name ?>&nbsp;&nbsp;
    <?php
        echo RHtmlHelper::linkAction('group', 'Manager: Edit group', 'edit', $group->id, array('class' => 'btn btn-xs btn-info'));
        echo '&nbsp;&nbsp;';echo RHtmlHelper::linkAction('group', 'Manager: Delete group', 'delete', $group->id, array('class' => 'btn btn-xs btn-danger'));
        echo '&nbsp;&nbsp;';echo RHtmlHelper::linkAction('group','Invite friends', 'invite', $group->id,array('class' => 'btn btn-xs btn-info'));
    ?>
</h2>

<?php
    echo RFormHelper::openForm('group/invite/'.$group->id,array('id'=>'build-group-form',
        'enctype'=>'multipart/form-data','class'=>'form-signin build-group-form'));
?>
    <div class="row"><br/>&nbsp;&nbsp;&nbsp;&nbsp;Select friends to invite:</div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="checkbox">
              <?php
              foreach($friends as $friend){
                  echo '<div class="col-6 col-sm-6 col-lg-4">';
                  echo '<label>'.RFormHelper::Input(array('type'=>'checkbox','name'=>'select_friends[]','value'=>$friend->id,'class'=>'btn btn-default')).$friend->name.'</label><br/>';
                  echo '</div>';
              }
               ?>
            </div>
        </div>
    </div>
<div class="row">&nbsp;&nbsp;&nbsp;&nbsp;Write something as a invitation (optional)</div>

<?php
    echo RFormHelper::textarea(array('class'=>'form-control','rows'=>'3','name'=>'invitation'));
    echo '<br/>';
    echo RFormHelper::input(
        array('class'=>'btn btn-lg btn-primary btn-block','type'=>'submit','value'=>'Invite Now'));
    echo RFormHelper::endForm();
?>