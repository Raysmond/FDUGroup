<?php

class PostController extends RController {
    /* List all topics belonging to a given group */
    public function actionList($groupId = null) {
        $topic = new Topic();
        $topic->groupId = $groupId;
        $topics = $topic->find();

    	$data = array("topics" => $topics, "groupId" => $groupId);

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

		$data = array("groupId" => $groupId);

		$this->setHeaderTitle("New topic");
		$this->render("edit", $data, false);
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

            $topic = new Topic();
            $topic->id = $topicId;
            $topics = $topic->find();
            $topics[0]->commentCount++;
            $topics[0]->update();

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
