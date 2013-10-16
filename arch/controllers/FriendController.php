<?php
class FriendController extends RController {
    /* Add friend request */
    public function actionAdd($userId = null) {
        /* TODO */
        $currentUserId = Rays::app()->getLoginUser()->id;
        $currentUserName = Rays::app()->getLoginUser()->name;
        $content = "$currentUserName wants to be friends with you.<br/>" .
            RHtmlHelper::link("Confirm", "Confirm", Rays::app()->getBaseUrl() . "/friend/confirm/$currentUserId") . "<br/>" .
            RHtmlHelper::link("Decline", "Decline", Rays::app()->getBaseUrl() . "/friend/decline/$currentUserId");

        $message = new Message();
        $message->sendMsg("system", $currentUserId, $userId, "Friend request", $content, '');

        $this->redirectAction('user', 'view', $userId);
    }

    /* Confirm friend request */
    public function actionConfirm($userId = null) {
        $currentUserId = Rays::app()->getLoginUser()->id;
        $currentUserName = Rays::app()->getLoginUser()->name;

        $friend = new Friend();
        $friend->uid = $currentUserId;
        $friend->fid = $userId;
        $friend->insert();

        $friend = new Friend();
        $friend->uid = $userId;
        $friend->fid = $currentUserId;
        $friend->insert();

        $content = "$currentUserName has accepted your friend request.";

        $message = new Message();
        $message->sendMsg("system", $currentUserId, $userId, "Friend confirmed", $content, '');

        $this->redirectAction('message', 'view', null);
    }

    /* Decline friend request */
    public function actionDecline($userId = null) {
        $currentUserId = Rays::app()->getLoginUser()->id;
        $currentUserName = Rays::app()->getLoginUser()->name;
        $content = "$currentUserName has declined your friend request.";
        $message = new Message();
        $message->sendMsg("system", $currentUserId, $userId, "Friend request declined", $content, '');

        $this->redirectAction('message', 'view', null);
    }
}
