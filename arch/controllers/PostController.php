<?php

class PostController extends RController {
    /* List all topics belonging to a given group */
    public function actionList($groupId = null) {
    	$_group = new Group();
    	$_group->id = $groupId;
    	$group = $_group->find()[0];

        $topic = new Topic();
        $topic->groupId = $groupId;
        $topics = $topic->find();

        $data = array("topics" => $topics, "group" => $group);

        $this->setHeaderTitle("Hello");
        $this->render("list", $data, false);
    }

    /* Add new topic */
    public function actionNew($groupId = null) {
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
                $topic->createdTime = date('Y-m-d H:i:s');
                $topic->lastCommentTime = date('Y-m-d H:i:s');
                $topic->commentCount = 0;
                $tid = $topic->insert();
                $this->redirectAction('post', 'view', $tid);
            }
        }

        $data = array("type" => "new", "groupId" => $groupId);

        $this->setHeaderTitle("New topic");
        $this->render("edit", $data, false);
    }

    /* Edit topic */
    public function actionEdit($topicId = null) {
        if ($this->getHttpRequest()->isPostRequest()) {
            $form = $_POST;

            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "content", "label" => "Content", "rules" => "trim|required"),
            ));

            if ($validation->run()) {
                $_topic = new Topic();
                $_topic->id = $topicId;
                $topic = $_topic->find()[0];
                $topic->title = $form["title"];
                $topic->content = $form["content"];
                $topic->update();
                $this->redirectAction('post', 'view', $topic->id);
            }
        }

        $topic = new Topic();
        $topic->id = $topicId;
        $topics = $topic->find();

        $data = array("type" => "edit", "topic" => $topics[0]);

        $this->render('edit', $data, false);
    }

    /* View topic */
    public function actionView($topicId = null) {
        $topic = new Topic();
        $topic->id = $topicId;
        $topics = $topic->find();

        $comment = new Comment();
        $comment->topicId = $topics[0]->id;
        $comments = $comment->find();

        $data = array("topic" => $topics[0], "comments" => $comments);

        $this->render("view", $data, false);
    }

    /* Add comment */
    public function actionComment($topicId = null) {
        if ($this->getHttpRequest()->isPostRequest()) {
            $form = $_POST;

            $_topic = new Topic();
            $_topic->id = $topicId;
            $topic = $_topic->find()[0];

            $topic->commentCount++;
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
}

?>
