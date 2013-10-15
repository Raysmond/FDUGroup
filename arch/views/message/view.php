<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 * Date: 13-10-15
 * Time: PM3:32
 * To change this template use File | Settings | File Templates.
 */
?>

<h2><?php echo count($msgs); ?> messages <?php echo ($type=='all'?"":$type); ?></h2>
<div class="navbar-left">
    <?php
    echo RFormHelper::openForm('message/send/user');
    echo RFormHelper::input(array('type'=>'hidden','name'=>'new','value'=>'true'));
    echo RFormHelper::input(array('type'=>'submit','value'=>'+ Write a message','class'=>'btn btn-sm btn-info'));
    echo RFormHelper::endForm();
    ?>
</div>

<div class="navbar-right">

<?php echo RHtmlHelper::linkAction('message',"All messages",'view','all',array('class'=>'btn btn-sm btn-primary'));?>

<?php echo RHtmlHelper::linkAction('message',"Unread messages",'view','unread',array('class'=>'btn btn-sm btn-success'));?>

<?php echo RHtmlHelper::linkAction('message',"Read messages",'view','read',array('class'=>'btn btn-sm btn-default'));?>
</div>
<div class="clearfix" style="margin-bottom: 10px;"></div>
<?php
    foreach($msgs as $msg)
    {
        echo '<div class="panel panel-info"><div class="panel-heading">';
        echo '<h3 class="panel-title">';
        $title =  (isset($msg->title)&&$msg->title!='')?$msg->title:"Untitled";
        echo RHtmlHelper::linkAction('message',$title,'detail',$msg->id);
        echo '</h3>';
        echo '</div><div class="panel-body">';
        $msg->load();
        if($msg->sender=='system'){
            echo "From: 系统消息";
        }
        else{
            //print_r($msg);
            $msg->sender->load();
            if($msg->sender instanceof User){
                echo "from: ".RHtmlHelper::linkAction('user',$msg->sender->name,'view',$msg->sender->id);
            }
            else if($msg->sender instanceof Group){
                echo "from: ".RHtmlHelper::linkAction('group',$msg->sender->name,'detail',$msg->sender->id);
            }
        }
        echo '&nbsp;&nbsp;Delivery time: '.$msg->sendTime;
        echo '&nbsp;&nbsp;Status: '.($msg->status==1?"unread":"read");
        echo "<br/>";
        echo '<p>'.RHtmlHelper::decode($msg->content).'</p>';

        if($msg->status==1):
            echo RHtmlHelper::linkAction('message',"Mark read",'read',$msg->id,array('class'=>'btn btn-sm btn-success'));
        endif;

        echo '</div></div>';
    }
?>
