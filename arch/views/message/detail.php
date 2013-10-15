<?php
/**
 * message detail page
 * @author: Raysmond
 */
?>
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $message->title; ?></h3>
    </div>
<div class="panel-body">
    <?php
    if($message->sender=='system'){
        echo "from: 系统消息";
    }
    else{
        if($message->sender instanceof User){
            echo "from: ".RHtmlHelper::linkAction('user',$message->sender->name,'view',$message->sender->id);
        }
        else if($message->sender instanceof Group){
            echo "from: ".RHtmlHelper::linkAction('group',$message->sender->name,'detail',$message->sender->id);
        }
    }
    echo '&nbsp;&nbsp;Delivery time: '.$message->sendTime;
    echo '&nbsp;&nbsp;Status: '.($message->status==0?"unread":"read");
    echo "<br/>";
    echo '<p>'.RHtmlHelper::decode($message->content).'</p>';

    if($message->status==1):
        echo RHtmlHelper::linkAction('message',"Mark read",'read',$message->id,array('class'=>'btn btn-sm btn-success'));
    endif;
    ?>
</div>
</div>