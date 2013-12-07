<?php
/**
 * User: Raysmond
 */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h1 class="panel-title">
            <?php echo $count; ?> messages <?php echo ($type=='all'?"":$type); ?>
        </h1>
    </div>
    <div class="panel-body">

        <div class="navbar-left">
            <?=RHtmlHelper::linkAction('message','+ Send a message','send',null,array('class'=>'btn btn-sm btn-info'))?>
        </div>

        <div class="navbar-right">
            <ul class="nav nav-tabs">
                <li <?=($type=='all'?'class="active"':"")?>><?=RHtmlHelper::linkAction('message','All messages','view','all')?></li>
                <li <?=($type=='unread'?'class="active"':"")?>><?=RHtmlHelper::linkAction('message','Unread messages','view','unread')?></li>
                <li <?=($type=='read'?'class="active"':"")?>><?=RHtmlHelper::linkAction('message','Read messages','view','read')?></li>
                <li <?=($type=='trash'?'class="active"':"")?>><?=RHtmlHelper::linkAction('message','Trash','view','trash')?></li>
            </ul>

        </div>
        <div class="clearfix" style="margin-bottom: 10px;"></div>
        <?php
        foreach($msgs as $msg)
        {
        ?>
        <div class="panel <?=($msg->status==Message::$STATUS_READ)?"panel-default":"panel-info"?>">
            <div class="panel-heading">
                <div style="float:right;margin-top: -2px;">
                    <?php
                    if($msg->receiverId==Rays::app()->getLoginUser()->id){
                        if($msg->status==Message::$STATUS_UNREAD) echo RHtmlHelper::linkAction('message',"Mark as read",'read',$msg->id,array('class'=>'btn btn-xs btn-success'));
                        echo '&nbsp;&nbsp;';
                        if($msg->status!=Message::$STATUS_TRASH) echo RHtmlHelper::linkAction('message',"Move to trash",'trash',$msg->id,array('class'=>'btn btn-xs btn-danger'));
                        if($type=='trash') echo RHtmlHelper::linkAction('message',"Delete",'delete',$msg->id,array('class'=>'btn btn-xs btn-danger'));
                    }
                    ?>
                </div>
                <h3 class="panel-title">
                    <?php
                    $title =  (isset($msg->title)&&$msg->title!='')?$msg->title:"Untitled";
                    echo RHtmlHelper::linkAction('message',$title,'detail',$msg->id);
                    echo '</h3>';
                    echo '</div><div class="panel-body">';
                    $msg->load();
                    echo '<div class="message-meta">';
                    if($msg->sender=='system'){
                        echo "From: 系统消息";
                    }
                    else{
                        //print_r($msg);
                        $msg->sender->load();
                        if($msg->sender instanceof User){
                            echo "From: ".RHtmlHelper::linkAction('user',$msg->sender->name,'view',$msg->sender->id);
                        }
                        else if($msg->sender instanceof Group){
                            echo "From: ".RHtmlHelper::linkAction('group',$msg->sender->name,'detail',$msg->sender->id);
                        }
                    }
                    echo '&nbsp;&nbsp;Delivery time: '.$msg->sendTime;
                    echo '&nbsp;&nbsp;Status: '.($msg->status==1?"unread":"read");
                    echo '</div>';
                    echo '<p>'.RHtmlHelper::decode($msg->content).'</p>';

                    echo '</div></div>';
                    }
                    ?>
                    <div>
                        <?=(isset($pager)?$pager:"")?>
                    </div>
    </div>
</div>


