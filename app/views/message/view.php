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
        <div class="message-container message-list">
        <?php
        foreach($msgs as $msg)
        {
        ?>
        <div id="message-item-<?=$msg->id?>" class="message-item panel panel-info <?=($msg->status==Message::STATUS_UNREAD)?"message-unread":""?>">
            <div class="panel-heading">
                <div style="float:right;margin-top: -2px;">
                    <?php
                    if($msg->receiverId==Rays::app()->getLoginUser()->id){

                        if(($msg->type->name=="private" || $msg->type->name=="user")&&$msg->senderId!=Rays::user()->id){
                            echo RHtmlHelper::linkAction("message","","send",['private',$msg->senderId],array('title'=>'Reply',"class"=>'glyphicon glyphicon-send'));
                            echo '&nbsp;&nbsp;&nbsp;';
                        }

                        if($msg->status==Message::STATUS_UNREAD)
                            echo RHtmlHelper::linkAction('message',"",'read',$msg->id,array('title' => 'Mark as read', 'class'=>'glyphicon glyphicon-ok message-read'));

                        echo '&nbsp;&nbsp;';

                        if($msg->status!=Message::STATUS_TRASH)
                            echo RHtmlHelper::linkAction('message',"",'trash',$msg->id,array('title'=> 'Mark as trash', 'class'=>'glyphicon glyphicon-trash message-trash'));

                        if($type=='trash')
                            echo RHtmlHelper::linkAction('message',"",'delete',$msg->id,array('title' => 'Delete', 'class'=>'glyphicon glyphicon-remove message-trash'));
                    }
                    ?>
                </div>
                    <?php
                    $title =  (isset($msg->title)&&$msg->title!='')?$msg->title:"Untitled";
                    echo RHtmlHelper::linkAction('message',$title,'detail',$msg->id);

                    echo '</div><div class="panel-body">';
                    echo '<div class="message-meta">';
                    if($msg->type->name=='system'){
                        echo "From: 系统消息";
                    }
                    else{
                         $sender = null;
                         if($msg->type->name == "user" || $msg->type->name =="private"){
                             $sender = User::get($msg->senderId);
                             if($sender!=null)
                                echo "From: ".RHtmlHelper::linkAction('user',$sender->name,'view',$sender->id);
                             else
                                 echo "From: Unknown user";
                         }
                         else if($msg->type->name == "group"){
                             $sender = Group::get($msg->senderId);
                             if($sender!=null)
                                echo "From: ".RHtmlHelper::linkAction('group',$sender->name,'detail',$sender->id);
                             else
                                 echo "From: Unknown group";
                         }
                         else{
                            echo "From: Unknown";
                         }

                    }
                    echo '&nbsp;&nbsp;Delivery time: '.$msg->sendTime;
                    echo '&nbsp;&nbsp;Status: '.($msg->status==1?"unread":"read");
                    echo '</div>';
                    echo '<div class="message-body" messageId="'.$msg->id.'">'.RHtmlHelper::decode($msg->content).'</div>';

                    echo '</div></div>';
                    }
                    ?>
                    </div>
                    <div>
                        <?=(isset($pager)?$pager:"")?>
                    </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".message-list .message-item .message-body a").click(function () {
            var id = $(this).parents(".message-body").attr("messageId");
            if (id) {
                $.ajax({
                    url: "<?=RHtmlHelper::siteUrl("message/read")?>",
                    type: "post",
                    data: {messageId: id},
                    success: function (data) {
                        if (data == "success") {
                            // do some thing
                        }
                    }
                });
            }
            return true;
        });
    });
</script>

