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
        <div class="navbar-left message-send">
            <a href="<?=RHtmlHelper::siteUrl('message/send')?>" title="send">
                <span class="glyphicon glyphicon-envelope"></span>
                Send Message
            </a>
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
        <div class="message-container">
        <?php
        foreach($msgs as $msg)
        {
        ?>
        <div class="panel panel-info <?=($msg->status==Message::STATUS_UNREAD)?"message-unread":""?>">
            <div class="panel-heading">
                <div style="float:right;margin-top: -2px;">
                    <?php
                    if($msg->receiverId==Rays::app()->getLoginUser()->id){
                        if($msg->status==Message::STATUS_UNREAD) echo RHtmlHelper::linkAction('message',"",'read',$msg->id,array('title' => 'Mark as read', 'class'=>'glyphicon glyphicon-ok message-read'));
                        echo '&nbsp;&nbsp;';
                        if($msg->status!=Message::STATUS_TRASH) echo RHtmlHelper::linkAction('message',"",'trash',$msg->id,array('title'=> 'Mark as trash', 'class'=>'glyphicon glyphicon-trash message-trash'));
                        if($type=='trash') echo RHtmlHelper::linkAction('message',"",'delete',$msg->id,array('title' => 'Delete', 'class'=>'glyphicon glyphicon-remove message-trash'));
                    }
                    ?>
                </div>
                    <?php
                    $title =  (isset($msg->title)&&$msg->title!='')?$msg->title:"Untitled";
                    echo RHtmlHelper::linkAction('message',$title,'detail',$msg->id);

                    echo '</div><div class="panel-body">';
                    echo '<div class="message-meta">';
                    if($msg->sender=='system'){
                        echo "From: 系统消息";
                    }
                    else{
                        /* TODO
                        if ($msg->sender !== null)
                            $msg->sender->load();
                        if($msg->sender instanceof User){
                            echo "From: ".RHtmlHelper::linkAction('user',$msg->sender->name,'view',$msg->sender->id);
                        }
                        else if($msg->sender instanceof Group){
                            echo "From: ".RHtmlHelper::linkAction('group',$msg->sender->name,'detail',$msg->sender->id);
                        }*/
                    }
                    echo '&nbsp;&nbsp;Delivery time: '.$msg->sendTime;
                    echo '&nbsp;&nbsp;Status: '.($msg->status==1?"unread":"read");
                    echo '</div>';
                    echo '<p>'.RHtmlHelper::decode($msg->content).'</p>';

                    echo '</div></div>';
                    }
                    ?>
                    </div>
                    <div>
                        <?=(isset($pager)?$pager:"")?>
                    </div>
    </div>
</div>


