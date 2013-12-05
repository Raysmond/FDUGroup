<?php

class PostController extends BaseController {
    public $access = array(
        Role::AUTHENTICATED=>array('new','list','edit','delete','comment'),
        Role::ADMINISTRATOR=>array('admin','active')
    );

    /* List all topics belonging to a given group */
    /* TODO List all topics with pagination */
    public function actionList($groupId = null) {
        $group = new Group();
        $group->id = $groupId;

        if(!is_numeric($groupId) || $group->load()===null){
            $this->page404();
            return;
        }

        $topic = new Topic();
        $topic->groupId = $groupId;
        $topics = $topic->find();

        $data = array("topics" => $topics, "group" => $group);

        $this->setHeaderTitle("Hello");
        $this->render("list", $data, false);
    }

    /* Add new topic */
    public function actionNew($groupId = null) {
        $data = array("type" => "new", "groupId" => $groupId);
        if($groupId!=null){
            $group = new Group();
            $group->load($groupId);
            $data['group'] = $group;
        }

        if ($this->getHttpRequest()->isPostRequest()) {
            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "post-content", "label" => "Content", "rules" => "trim|required"),
            ));

            if ($validation->run()) {
                $topic = new Topic();
                $topic->groupId = $groupId;
                $topic->userId = Rays::app()->getLoginUser()->id;
                $topic->title = $_POST["title"];
                $topic->content = RHtmlHelper::encode($_POST['post-content']);
                $topic->createdTime = date('Y-m-d H:i:s');
                $topic->lastCommentTime = date('Y-m-d H:i:s');
                $topic->commentCount = 0;
                $tid = $topic->insert();
                $this->redirectAction('post', 'view', $tid);
            }
            else{
                $data['newPostForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $this->setHeaderTitle("New topic");
        $this->render("edit", $data, false);
    }

    /* Edit topic */
    public function actionEdit($topicId) {
        $topic = new Topic();

        if(!is_numeric($topicId) || $topic->load($topicId) === null){
            $this->page404();
            return;
        }

        if ($this->getHttpRequest()->isPostRequest()) {
            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "post-content", "label" => "Content", "rules" => "trim|required"),
            ));

            $topic->title = $_POST['title'];
            $topic->content = RHtmlHelper::encode($_POST['post-content']);

            if ($validation->run()) {
                $topic->update();
                $this->flash("message","Post ".$topic->title." was updated successfully.");
                $this->redirectAction('post','view', $topic->id);
            }
            else{
                $data['validation_errors'] = $validation->getErrors();
            }
        }
        $group = new Group();
        $group->load($topic->groupId);
        $data = array("type" => "edit", "topic" => $topic,'group'=>$group);
        $this->setHeaderTitle("Edit post: ".$topic->title);
        $this->render('edit', $data, false);
    }

    /* View topic */
    public function actionView($topicId = null) {
        $topic = new Topic();

        if(!is_numeric($topicId) || $topic->load($topicId) === null){
            $this->page404();
            return;
        }

        $counter = $topic->increaseCounter();
        $topic->user->load();
        $topic->group->load();
        $commentTree = $topic->getComments();

        foreach($commentTree as $commentItem){
            $commentItem['root']->user = new User();
            $commentItem['root']->user->load($commentItem['root']->userId);
            foreach ($commentItem['reply'] as $reply) {
                $reply->user = new User();
                $reply->user->load($reply->userId);
            }
        }

        $data = array("topic" => $topic, "commentTree" => $commentTree,'counter'=>$counter);

        $replyTo = $this->getHttpRequest()->getParam('reply',null);
        if($replyTo && is_numeric($replyTo)){
            $comment = new Comment();
            $comment->load($replyTo);
            $comment->user->load();
            $data['parent'] = $comment;
        }

        $this->setHeaderTitle($topic->title);
        $this->render("view", $data, false);

    }

    /* Add comment */
    public function actionComment($topicId) {
        $topic = new Topic();

        if(!$topicId || !is_numeric($topicId) || $topic->load($topicId) === null){
            $this->page404();
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

            $topic->commentCount++;
            $topic->lastCommentTime = date('Y-m-d H:i:s');
            $topic->update();

            $user = Rays::app()->getLoginUser();

            $comment = new Comment();
            $comment->topicId = $topicId;
            $comment->userId = $user->id;
            $comment->createdTime = date('Y-m-d H:i:s');
            $comment->content = $form["content"];
            if (isset($form['replyTo'])) {
                $comment->pid = (int)$form['replyTo'];
            }
            $cid = $comment->insert();
            //if ($comment->pid !== 0)
            //    $cid = $comment->pid;

            if (isset($form['replyTo'])) {
                $exactComment = new Comment();
                $exactComment->load($form['exactReplyTo']);
                $msg = new Message();
                $msg->sendMsg(
                    'user',
                    $user->id,
                    $exactComment->userId,
                     'New reply',
                    $user->name . ' has replied to your comment ' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id.'?reply='.$cid),
                    date('Y-m-d H:i:s')
                );
            }
            //send message to topic author
           else if ($topic->userId !== $user->id) {
                $msg = new Message();
                $msg->sendMsg(
                    'user',
                    $user->id,
                    $topic->userId, 'New Comment',
                    $user->name . ' has replied to your topic ' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id.'?reply='.$cid),
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
        $topic = new Topic();
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
        $topics = $topic->getActiveTopics($beginTime, 10);
        $data['topics'] = $topics;
        $this->render('active', $data, false);
    }


    public function actionDelete($topicId)
    {
        $topic = new Topic();

        if (!is_numeric($topicId) || $topic->load($topicId) === null) {
            $this->page404();
            return;
        }
        else{
            $topic->delete();
            $this->flash("message", "Post " . $topic->title . " was deleted.");
            if(Rays::referrerUri()){
                $this->redirect(Rays::referrerUri());
            }
        }
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

        $curPage = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize");

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
