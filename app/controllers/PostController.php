<?php

class PostController extends BaseController
{
    public $access = array(
        Role::AUTHENTICATED => array('new', 'list', 'edit', 'delete', 'comment'),
        Role::ADMINISTRATOR => array('admin', 'active')
    );

    public $post = null;
    public $group = null;

    public function beforeAction($action)
    {
        $params = $this->getActionParams();
        $result = true;
        switch ($action) {
            case "list":
                $group = new Group();
                if (!$params || !isset($params[0]) || !is_numeric($params[0]) || $group->load($params[0]) === null) {
                    $result = false;
                } else {
                    $this->group = $group;
                    $result = true;
                }
                break;
            case "edit":
            case "view":
            case "comment":
            case "delete":
                $topic = new Topic();
                if (!$params || !isset($params[0]) || !is_numeric($params[0]) || $topic->load($params[0]) === null) {
                    $result = false;
                } else {
                    $this->post = $topic;
                    $result = true;
                }
                break;

        }
        if (!$result) {
            $this->page404();
            return false;
        }
        return $result;
    }

    /* List all topics belonging to a given group */
    /* TODO List all topics with pagination */
    public function actionList($groupId = null)
    {
        // group loaded in beforeAction() method
        $group = $this->group;

        $topic = new Topic();
        $topic->groupId = $groupId;
        $topics = $topic->find();

        $data = array("topics" => $topics, "group" => $group);

        $this->setHeaderTitle("Hello");
        $this->render("list", $data, false);
    }

    /* Add new topic */
    public function actionNew($groupId = null)
    {
        $data = array("type" => "new", "groupId" => $groupId);
        $data['groups'] = GroupUser::userGroups(0, 0, Rays::user()->id);

        $data['groupId'] = null;
        if ($groupId != null) {
            foreach($data['groups'] as $item){
                if($item->id == $groupId){
                    $data['groupId'] = $groupId;
                    break;
                }
            }
        }

        if (Rays::isPost()) {
            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "post-content", "label" => "Content", "rules" => "trim|required"),
            ));

            if ($validation->run()) {
                $topic = new Topic();
                $topic->groupId = $groupId;
                $topic->userId = Rays::user()->id;
                $topic->title = $_POST["title"];
                $topic->content = RHtmlHelper::encode($_POST['post-content']);
                $topic->createdTime = date('Y-m-d H:i:s');
                $topic->lastCommentTime = date('Y-m-d H:i:s');
                $topic->commentCount = 0;
                $tid = $topic->insert();
                $this->redirectAction('post', 'view', $tid);
            } else {
                $data['newPostForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $this->layout = 'user';
        $this->setHeaderTitle("New topic");
        $this->render("edit", $data, false);
    }

    /* Edit topic */
    public function actionEdit($topicId)
    {
        // topic loaded in beforeAction() method
        $topic = $this->post;

        if (Rays::isPost()) {
            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "post-content", "label" => "Content", "rules" => "trim|required"),
            ));

            $topic->title = $_POST['title'];
            $topic->content = RHtmlHelper::encode($_POST['post-content']);

            if ($validation->run()) {
                $topic->update();
                $this->flash("message", "Post " . $topic->title . " was updated successfully.");
                $this->redirectAction('post', 'view', $topic->id);
            } else {
                $data['validation_errors'] = $validation->getErrors();
            }
        }
        $group = new Group();
        $group->load($topic->groupId);
        $data = array("type" => "edit", "topic" => $topic, 'group' => $group);

        $this->layout = 'user';
        $this->setHeaderTitle("Edit post: " . $topic->title);
        $this->render('edit', $data, false);
    }

    /* View topic */
    public function actionView($topicId = null)
    {
        // topic loaded in beforeAction() method
        $topic = $this->post;

        $counter = $topic->increaseCounter();
        $topic->user->load();
        $topic->group->load();
        $commentTree = $topic->getComments();

        foreach ($commentTree as $commentItem) {
            $commentItem['root']->user = new User();
            $commentItem['root']->user->load($commentItem['root']->userId);
            foreach ($commentItem['reply'] as $reply) {
                $reply->user = new User();
                $reply->user->load($reply->userId);
            }
        }

        $data = array("topic" => $topic, "commentTree" => $commentTree, 'counter' => $counter);

        $replyTo = Rays::getParam('reply', null);
        if ($replyTo && is_numeric($replyTo)) {
            $comment = new Comment();
            $comment->load($replyTo);
            $comment->user->load();
            $data['parent'] = $comment;
        }

        $data['canEdit'] = (Rays::isLogin() && (Rays::user()->id==$topic->user->id || Rays::user()->isAdmin()));

        $this->setHeaderTitle($topic->title);
        $this->render("view", $data, false);

    }

    /* Add comment */
    public function actionComment($topicId)
    {
        // topic loaded in beforeAction() method
        $topic = $this->post;

        if (Rays::isPost()) {
            $validation = new RFormValidationHelper(array(
                array('field' => 'content', 'label' => 'Content', 'rules' => 'trim|required')));
            if (!$validation->run()) {
                $this->flash("error", "Comment content cannot be empty!");
                $this->redirectAction('post', 'view', $topicId);
            }
            $form = $_POST;

            $topic->commentCount++;
            $topic->lastCommentTime = date('Y-m-d H:i:s');
            $topic->update();

            $user = Rays::user();

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
                    $user->name . ' has replied to your comment ' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id . '?reply=' . $cid),
                    date('Y-m-d H:i:s')
                );
            } //send message to topic author
            else if ($topic->userId !== $user->id) {
                $msg = new Message();
                $msg->sendMsg(
                    'user',
                    $user->id,
                    $topic->userId, 'New Comment',
                    $user->name . ' has replied to your topic ' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id . '?reply=' . $cid),
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
        // topic loaded in beforeAction() method
        $topic = $this->post;

        $topic->delete();
        $this->flash("message", "Post " . $topic->title . " was deleted.");
        if (Rays::referrerUri()) {
            $this->redirect(Rays::referrerUri());
        }
    }

    /**
     * Topics administration
     */
    public function actionAdmin()
    {
        $this->layout = 'admin';
        $data = array();

        // delete request
        if (Rays::isPost()) {
            if (isset($_POST['checked_topics'])) {
                $checkedTopics = $_POST['checked_topics'];
                foreach ($checkedTopics as $item) {
                    if (!is_numeric($item)) return;
                    else {
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

        $this->render('admin', $data, false);
    }

}
