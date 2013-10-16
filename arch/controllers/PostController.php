<?php

class PostController extends RController {
    public $access = array(
        Role::AUTHENTICATED=>array('list','edit','delete')
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
                $topic->content = $form["content"];
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
        $this->render("edit", $data, false);
    }

    /* Edit topic */
    public function actionEdit($topicId) {
        $topic = new Topic();
        $topic->load($topicId);

        if ($this->getHttpRequest()->isPostRequest()) {
            $form = $_POST;

            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "content", "label" => "Content", "rules" => "trim|required"),
            ));

            if ($validation->run()) {
                $topic = new Topic();
                $topic->id = $topicId;
                $topic->load();
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
        $topic->load($topicId);
        $topic->user->load();
        $topic->group->load();

        $comments = $topic->getComments();
        foreach($comments as $comment){
            $comment->user = new User();
            $comment->user->load($comment->userId);
        }
        $this->setHeaderTitle($topic->title);
        $data = array("topic" => $topic, "comments" => $comments);
        $this->render("view", $data, false);
    }

    /* Add comment */
    public function actionComment($topicId) {
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
            $comment->insert();
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
