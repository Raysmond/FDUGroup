<?php
    $self->setHeaderTitle($message->title);
?>
<div class="message-container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo $message->title; ?></h3>
        </div>
        <div class="panel-body">
            <?php
            if ($message->type->name == 'system') {
                echo "From: 系统消息";
            } else {
                $sender = null;
                if ($message->type->name == "user" || $message->type->name == "private") {
                    $sender = User::get($message->senderId);
                    echo "From: " . RHtml::linkAction('user', $sender->name, 'view', $sender->id);
                } else if ($message->type->name == "group") {
                    $sender = Group::get($message->senderId);
                    echo "From: " . RHtml::linkAction('group', $sender->name, 'detail', $sender->id);
                } else {
                    echo "From: Unknown";
                }

            }
            echo '&nbsp;&nbsp;Delivery time: ' . $message->sendTime;
            echo '&nbsp;&nbsp;Status: ' . ($message->status == 0 ? "unread" : "read");
            echo "<br/>";
            echo '<p>' . RHtml::decode($message->content) . '</p>';

            if ($message->status == Message::STATUS_UNREAD && $message->receiverId == Rays::user()->id):
                echo RHtml::linkAction('message', "Mark read", 'read', $message->id, array('class' => 'btn btn-sm btn-success'));
            endif;
            ?>
        </div>
    </div>
</div>