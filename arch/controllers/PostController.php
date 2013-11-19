<?php

class PostController extends RController {
    public $access = array(
        Role::AUTHENTICATED=>array('new','list','edit','delete','comment')
    );

    /* List all topics belonging to a given group */
    public function actionList($groupId = null) {
        $group = new Group();
        $group->id = $groupId;
        $group->load();

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
            $form = $_POST;

            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "content", "label" => "Content", "rules" => "trim|required"),
            ));

            if ($validation->run()) {
                $topic = new Topic();
                $topic->groupId = $groupId;
                $topic->userId = Rays::app()->getLoginUser()->id;
                $topic->title = $form["title"];
                $topic->content = RHtmlHelper::encode($form['content']);
                date_default_timezone_set(Rays::app()->getTimeZone());
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
        $this->addJs('/public/ckeditor/ckeditor.js');
        $this->render("edit", $data, false);
    }

    /* Edit topic */
    public function actionEdit($topicId) {
        $topic = new Topic();
        $topic->load($topicId);

        if ($this->getHttpRequest()->isPostRequest()) {


            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "content", "label" => "Content", "rules" => "trim|required"),
            ));
            $form = $_POST;
            $topic->title = $form['title'];
            $topic->content = RHtmlHelper::encode($form['content']);

            if ($validation->run()) {
                $topic->update();
                $this->flash("message","Post ".$topic->title." was updated successfully.");
                $this->redirectAction('post','view',$topic->id);
            }
            else{
                $data['validation_errors'] = $validation->getErrors();
            }
        }
        $group = new Group();
        $group->load($topic->groupId);
        $data = array("type" => "edit", "topic" => $topic,'group'=>$group);
        $this->setHeaderTitle("Edit post: ".$topic->title);
        $this->addJs('/public/ckeditor/ckeditor.js');
        $this->render('edit', $data, false);
    }

    /* View topic */
    public function actionView($topicId = null) {
        if (!is_numeric($topicId) && $topicId === null) {
            Rays::app()->page404();
            return;
        }

        $topic = new Topic();
        $topic->load($topicId);
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
        $this->setHeaderTitle($topic->title);
        $data = array("topic" => $topic, "commentTree" => $commentTree);

        $replyTo = $this->getHttpRequest()->getParam('reply',null);
        if($replyTo&&is_numeric($replyTo)){
            $comment = new Comment();
            $comment->load($replyTo);
            $comment->user->load();
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

            $topic = new Topic();
            $topic->load($topicId);

            $topic->commentCount++;
            date_default_timezone_set(Rays::app()->getTimeZone());
            $topic->lastCommentTime = date('Y-m-d H:i:s');
            $topic->update();

            $comment = new Comment();
            $comment->topicId = $topicId;
            $comment->userId = Rays::app()->getLoginUser()->id;
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
                    Rays::app()->getLoginUser()->id,
                    $exactComment->userId,
                     'New reply',
                    Rays::app()->getLoginUser()->name . ' has replied to your comment ' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id.'?reply='.$cid),
                    date('Y-m-d H:i:s')
                );
            }
            //send message to topic author
           else if ($topic->userId !== Rays::app()->getLoginUser()->id) {
                $msg = new Message();
                $msg->sendMsg(
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


    // access: author and administrator
    public function actionDelete($topicId)
    {
        if(!isset($topicId)||$topicId==''||!is_numeric($topicId)){
            Rays::app()->page404();
            return;
        }
        $topic = new Topic();
        $topic->load($topicId);
        if(isset($topic->id)&&$topic->id!=''){
            $comments = $topic->getComments();
            foreach($comments as $comment)
                $comment->delete();
            $topic->delete();
            $this->flash("message","Post ".$topic->title." was deleted.");
        }
        else{
            $this->flash("error","No such post.");
        }
        $this->redirectAction('group','view',Rays::app()->getLoginUser()->id);
    }
}

?>
