<?php
/** invite friends to join the group 'i' created... */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="heading-actions" style="float: right;">
            <?=RHtml::linkAction('group',"Back to group",'detail',$group->id,array('class'=>'btn btn-xs btn-info'))?>
        </div>

        <h1 class="panel-title"><?= $group->name ?></h1>
    </div>

    <div class="panel-body">
        <?php
        echo RForm::openForm('group/invite/'.$group->id,array('id'=>'invite-group-form','class'=>'form-signin build-group-form'));
        ?>
        <div><br/><b>Select friends to invite:</b></div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="checkbox friends-list">
                    <?php
                    foreach($friends as $friend){
                        echo '<div class="col-lg-2 friend-item" style="height: 90px;">';
                        if(!isset($friend->user->picture)||$friend->user->picture=='') $friend->user->picture = User::$defaults['picture'];
                        $picture = RImage::styleSrc($friend->user->picture,User::getPicOptions());
                        echo RHtml::showImage($picture,$friend->user->name,array('width'=>'64px'));
                        echo '<br/>';
                        echo RForm::input(array('type'=>'checkbox','name'=>'select_friends[]','value'=>$friend->user->id,'class'=>'btn btn-default'));
                        echo RHtml::linkAction('user',$friend->user->name,'view',$friend->user->id);
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <hr>

        <div><b>Write something as an invitation (optional)</b></div>

        <?php
        echo RForm::textarea(array('class'=>'form-control','rows'=>'3','name'=>'invitation','placeholder'=>'Say something!'));
        echo '<br/>';
        echo RForm::input(
            array('class'=>'btn btn-lg btn-primary','type'=>'submit','value'=>'Invite Now'));
        echo RForm::endForm();
        ?>
    </div>

</div>