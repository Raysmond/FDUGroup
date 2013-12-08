<?php

class PostController extends BaseController {
    public $access = array(
        Role::AUTHENTICATED=>array('new','list','edit','delete','comment'),
        Role::ADMINISTRATOR=>array('admin','active')
    );

    /* List all topics belonging to a given group */
    public function actionList($groupId = null) {
        $group = Group::get($groupId);
        $topics = Topic::find("groupId", $groupId)->all();

        $data = array("topics" => $topics, "group" => $group);

        $this->setHeaderTitle($group->name);
        $this->render("list", $data, false);
    }

    /* Add new topic */
    public function actionNew($groupId = null) {
        $data = array("type" => "new", "groupId" => $groupId);

        if ($this->getHttpRequest()->isPostRequest()) {
            $form = $_POST;

            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "post-content", "label" => "Content", "rules" => "trim|required"),
            ));

            if ($validation->run()) {
                $topic = new Topic();
                $topic->groupId = $groupId;
                $topic->userId = Rays::app()->getLoginUser()->id;
                $topic->title = $form["title"];
                $topic->content = RHtmlHelper::encode($form['post-content']);
                date_default_timezone_set(Rays::app()->getTimeZone());
                $topic->createdTime = date('Y-m-d H:i:s');
                $topic->lastCommentTime = date('Y-m-d H:i:s');
                $topic->commentCount = 0;
                $topic->save();
                $this->redirectAction('post', 'view', $topic->id);
            }
            else{
                $data['newPostForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $group = Group::get($groupId);
        $data['group'] = $group;
        $this->setHeaderTitle("New topic");
        $this->render("edit", $data, false);
    }

    /* Edit topic */
    public function actionEdit($topicId) {
        $topic = Topic::get($topicId);

        if ($this->getHttpRequest()->isPostRequest()) {
            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "post-content", "label" => "Content", "rules" => "trim|required"),
            ));
            $form = $_POST;
            $topic->title = $form['title'];
            $topic->content = RHtmlHelper::encode($form['post-content']);

            if ($validation->run()) {
                $topic->save();
                $this->flash("message","Post ".$topic->title." was updated successfully.");
                $this->redirectAction('post','view',$topic->id);
            }
            else{
                $data['validation_errors'] = $validation->getErrors();
            }
        }
        $group = Group::get($topic->groupId);
        $data = array("type" => "edit", "topic" => $topic,'group' => $group);
        $this->setHeaderTitle("Edit post: ".$topic->title);
        $this->render('edit', $data, false);
    }

    /* View topic */
    public function actionView($topicId = null) {
        if (!is_numeric($topicId) && $topicId === null) {
            Rays::app()->page404();
            return;
        }

        $topic = Topic::get($topicId);
        if ($topic == null) {
            Rays::app()->page404();
            return;
        }

        $counter = $topic->increaseCounter();
        $topic->user = User::get($topic->userId);
        $topic->group = User::get($topic->groupId);

        $commentTree = $topic->getComments();

        /* TODO: Join */
        foreach($commentTree as $commentItem){
            $commentItem['root']->user = User::get($commentItem['root']->userId);
            foreach ($commentItem['reply'] as $reply) {
                $reply->user = User::get($reply->userId);
            }
        }
        $this->setHeaderTitle($topic->title);
        $data = array("topic" => $topic, "commentTree" => $commentTree,'counter'=>$counter);

        $replyTo = $this->getHttpRequest()->getParam('reply',null);
        if($replyTo&&is_numeric($replyTo)){
            $comment = Comment::get($replyTo);
            $comment->user = User::get($comment->userId);
            $data['parent'] = $comment;
        }
        $this->render("view", $data, false);

    }

    /* Add comment */
    public function actionComment($topicId) {
        if($topicId===null&&!is_numeric($topicId)){
            Rays::app()->page404();
            return;
        }
        if ($this->getHttpRequest()->isPostRequest()) {
            $validation = new RFormValidationHelper(array(
                array('field'=>'content','label'=>'Content','rules'=>'trim|required')));
            if(!$validation->run())
            {
                $this->flash("error","Comment content cannot be empty!");
                $this->redirectAction('post', 'view', $topicId);
            }
            $form = $_POST;

            $topic = Topic::get($topicId);
            $topic->commentCount++;
            date_default_timezone_set(Rays::app()->getTimeZone());
            $topic->lastCommentTime = date('Y-m-d H:i:s');
            $topic->save();

            $comment = new Comment();
            $comment->topicId = $topicId;
            $comment->userId = Rays::app()->getLoginUser()->id;
            $comment->createdTime = date('Y-m-d H:i:s');
            $comment->content = $form["content"];
            if (isset($form['replyTo'])) {
                $comment->pid = (int)$form['replyTo'];
            }
            else {
                $comment->pid = 0;
            }
            $comment->save();
            $cid = $comment->id;

            if (isset($form['replyTo'])) {
                $exactComment = Comment::get($form['exactReplyTo']);
                Message::sendMsg(
                    'user',
                    Rays::app()->getLoginUser()->id,
                    $exactComment->userId,
                     'New reply',
                    Rays::app()->getLoginUser()->name . ' has replied to your comment ' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id.'?reply='.$cid),
                    date('Y-m-d H:i:s')
                );
            }
            //send message to topic author
           else if ($topic->userId !== Rays::app()->getLoginUser()->id) {
                Message::sendMsg(
                    'user',
                    Rays::app()->getLoginUser()->id,
                    $topic->userId, 'New Comment',
                    Rays::app()->getLoginUser()->name . ' has replied to your topic ' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id.'?reply='.$cid),
                    date('Y-m-d H:i:s')
                );
            }



        }
        $this->redirectAction('post', 'view', $topicId);
    }

    public function actionActive($time = null)
    {
        $this->layout = 'admin';
        $data = array();
        $beginTime = null;
        $date = date('Y-m-d');
        switch ($time) {
            case "day":
                $beginTime = date('Y-m-d: 00:00:00');
                break;
            case "week":
                $lastDay = date("Y-m-d", strtotime("$date Sunday"));
                $beginTime = date("Y-m-d 00:00:00", strtotime("$lastDay -6 days"));
                break;
            case "month":
                $beginTime = date("Y-m-01 00:00:00", strtotime($date));
            default:
        }
        $query = Topic::find()->join("user")->join("group")->order_desc("commentCount");
        if ($beginTime != null) {
            $query = $query->where("[createdTime] > ?", $beginTime);
        }
        $topics = $query->range(0, 10);
        $data['topics'] = $topics;
        $this->render('active', $data, false);
    }


    // access: author and administrator
    public function actionDelete($topicId)
    {
        if (!isset($topicId) || $topicId == '' || !is_numeric($topicId)) {
            Rays::app()->page404();
            return;
        }
        $topic = Topic::get($topicId);
        if (isset($topic->id) && $topic->id != '') {
            $topic->delete();
            $this->flash("message", "Post " . $topic->title . " was deleted.");
        } else {
            $this->flash("error", "No such post.");
        }
        $this->redirectAction('group', 'view', Rays::app()->getLoginUser()->id);
    }

    /**
     * Topics administration
     */
    public function actionAdmin(){
        $this->layout = 'admin';
        $data = array();

        // delete request
        if($this->getHttpRequest()->isPostRequest()){
            if(isset($_POST['checked_topics'])){
                $checkedTopics = $_POST['checked_topics'];
                foreach($checkedTopics as $item){
                    if(!is_numeric($item)) return;
                    else{
                        $topic = new Topic();
                        $topic->id = $item;
                        $topic->delete();
                    }
                }
            }
        }

        $curPage = $this->getHttpRequest()->getQuery('page', 1);
        $pageSize = 5;

        $rows = new Topic();
        $count = $rows->count();
        $data['count'] = $count;

        $topics = new Topic();
        $topics = $topics->adminFindAll(($curPage - 1) * $pageSize, $pageSize, array('key' => 'id', "order" => 'desc'));
        $data['topics'] = $topics;

        $pager = new RPagerHelper('page', $count, $pageSize, RHtmlHelper::siteUrl('post/admin'), $curPage);
        $pager = $pager->showPager();
        $data['pager'] = $pager;

        $this->render('admin',$data,false);
    }
}

?>
