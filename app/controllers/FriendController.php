<?php
/**
 * Class FriendController
 *
 * @author: Xiangyan Sun, Renchu Song, Raysmond
 */
class FriendController extends BaseController {
    public $access = array(
        Role::AUTHENTICATED => array('add', 'confirm', 'decline')
    );

    public $_user;

    public function filteredUser(){
        return isset($this->_user)?$this->_user : null;
    }

    public function beforeAction($action)
    {
        $params = $this->getActionParams();
        $result = true;
        switch ($action) {
            case "add":
            case "confirm":
            case "decline":
            case "cancel":
                $result = false;
                $user = null;
                if (isset($params) && isset($params[0]) && is_numeric($params[0]) && ($user = User::get($params[0])) !== null) {
                    $result = true;
                    $this->_user = $user;
                }
                break;
        }
        if(!$result){
            $this->page404();
            return false;
        }
        return true;
    }

    /* Add friend request */
    public function actionAdd($userId = null) {
        // the user whose id = $userId
        // loaded in beforeAction() method
        // $user = $this->filteredUser();

        $uid = Rays::user()->id;
        if ($uid !== $userId) {
            $content = $this->renderPartial('_add_friend_msg', array('user'=>Rays::user()),true);
            Message::sendMessage("system", $uid, $userId, "Friend request", $content);

            //add friend censor item
            $censor = new Censor();
            $censor->addFriendApplication($uid, $userId);
            $this->flash('message', 'Adding friend request has been sent.');
            $this->redirectAction('user', 'view', $userId);
        }
    }

    /* Confirm friend request */
    public function actionConfirm($userId = null) {
        $uid = Rays::user()->id;
        $userName = Rays::user()->name;

        $friend = Friend::find(['fid',$userId,'uid',$uid])->first();



        //only request exist can friendship be built
        $censor = (new Censor())->addFriendExist($userId, $uid);

        if ($censor === null) {
            $this->flash('warning','Request already processed');
        } else {
            $censor->pass();
            if ($friend == null) {     //bug fixed by songrenchu: only new relationship need to be inserted
                $friend = new Friend();
                $friend->fid = $userId;
                $friend->uid = $uid;
                $friend->save();

                $friend = new Friend();
                $friend->uid = $userId;
                $friend->fid = $uid;
                $friend->save();

                $content = RHtmlHelper::linkAction('user',$userName,'view',$uid)." has accepted your friend request.";

                Message::sendMessage("system", $uid, $userId, "Friend confirmed", $content, '');
                $this->flash('message','Friends confirmed.');
            }
            else{
                $this->flash('warning','You two are already friends.');
            }
        }

        $this->redirectAction('message', 'view', null);
    }

    /* Decline friend request */
    public function actionDecline($userId = null) {
        $uid = Rays::user()->id;
        $userName = Rays::user()->name;

        //only request exist can friendship be declined
        $censor = (new Censor())->addFriendExist($userId, $uid);

        if ($censor === null) {
            $this->flash('warning','Request already processed');
        } else {
            $censor->fail();

            $content = RHtmlHelper::linkAction('user',$userName,'view',$uid)." has declined your friend request.";
            Message::sendMessage("system", $uid, $userId, "Friend request declined", $content, '');
            $this->flash('message','Friend request declined.');
        }
        $this->redirectAction('message', 'view', null);
    }

    /* Cancel friend relationship */
    public function actionCancel($userId = null) {
        $uid = Rays::user()->id;

        $friend = Friend::find(['uid',$uid,'fid',$userId])->first();
        if($friend!=null)
            $friend->delete();

        $friend = Friend::find(['fid',$uid,'uid',$userId])->first();
        if($friend!=null)
            $friend->delete();

        $this->redirectAction('user', 'view', $userId);
    }

    public function actionMyFriend() {
        $this->layout = 'user';
        $user = Rays::user();

        $friends = new Friend();
        $curPage = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize",36);

        list($friends, $count) = $friends->getFriends($user->id, $pageSize, [], ($curPage - 1) * $pageSize);
        $data['count'] = $count;

        $pager = new RPagerHelper('page', $count, $pageSize, RHtmlHelper::siteUrl('friend/myFriend'), $curPage);
        $data['friends'] = $friends;

        if($count>$pageSize)
            $data['pager'] = $pager->showPager();
        $data['friNumber'] = $count;

        return $this->render('my_friend',$data);

    }
}
