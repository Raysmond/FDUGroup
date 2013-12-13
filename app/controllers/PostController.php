<?php
/**
 * Class PostController
 *
 * @author: Xiangyan Sun, Raysmond
 */
class PostController extends BaseController
{
    public $access = array(
        Role::AUTHENTICATED => array('new', 'list', 'edit', 'delete', 'comment'),
        Role::ADMINISTRATOR => array('admin', 'active')
    );

    /* List all topics belonging to a given group */
    public function actionList($groupId = null)
    {
        $group = Group::get($groupId);

        $page = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize", 10);

        $query = Topic::find("groupId", $groupId)->join("user")->order_desc("lastCommentTime");
        $count = $query->count();
        $topics = $query->range(($page - 1) * $pageSize, $pageSize);

        $data = array("topics" => $topics, "group" => $group);
        $pager = new RPagerHelper("page", $count, $pageSize, RHtmlHelper::siteUrl("post/list/" . $groupId), $page);
        $data['pager'] = $pager->showPager();

        $data['canPost'] = Rays::isLogin() && GroupUser::isUserInGroup(Rays::user()->id,$groupId);

        $this->setHeaderTitle("Hello");
        $this->addCss('/public/css/post.css');
        $this->render("list", $data, false);
    }

    /* Add new topic */
    public function actionNew($groupId = null)
    {
        $data = array("type" => "new", "groupId" => $groupId);
        $data['groups'] = GroupUser::getGroups(GroupUser::find("userId", Rays::user()->id)->join("group")->order_desc("groupId")->all());

        if (Rays::isPost()) {
            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "group", "label" => "Group", "rules" => "trim|required|number"),
                array("field" => "post-content", "label" => "Content", "rules" => "trim|required"),
            ));

            if ($validation->run()) {
                $topic = new Topic();
                $topic->groupId = $_POST['group'];
                $topic->userId = Rays::user()->id;
                $topic->title = $_POST["title"];
                $topic->content = RHtmlHelper::encode($_POST['post-content']);
                $topic->createdTime = date('Y-m-d H:i:s');
                $topic->lastCommentTime = date('Y-m-d H:i:s');
                $topic->commentCount = 0;
                $topic->save();
                $this->redirectAction('post', 'view', $topic->id);
            } else {
                $data['newPostForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $this->layout = 'user';
        $this->addCss('/public/css/post.css');
        $this->setHeaderTitle("New topic");
        $this->render("edit", $data, false);
    }

    /* Edit topic */
    public function actionEdit($topicId)
    {
        $topic = Topic::get($topicId);

        if (Rays::isPost()) {
            $validation = new RFormValidationHelper(array(
                array("field" => "title", "label" => "Title", "rules" => "trim|required"),
                array("field" => "post-content", "label" => "Content", "rules" => "trim|required"),
            ));

            $topic->title = $_POST['title'];
            $topic->content = RHtmlHelper::encode($_POST['post-content']);

            if ($validation->run()) {
                $topic->save();
                $this->flash("message", "Post " . $topic->title . " was updated successfully.");
                $this->redirectAction('post', 'view', $topic->id);
            } else {
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $group = Group::get($topic->groupId);
        $data = array("type" => "edit", "topic" => $topic, 'group' => $group,'groupId'=>$group->id);
        $data['groups'] = GroupUser::getGroups(GroupUser::find("userId", Rays::user()->id)->join("group")->order_desc("groupId")->all());

        $this->layout = 'user';
        $this->addCss('/public/css/post.css');
        $this->setHeaderTitle("Edit post: " . $topic->title);
        $this->render('edit', $data, false);
    }

    /* View topic */
    public function actionView($topicId = null)
    {
        $topic = Topic::find($topicId)->join("group")->join("user")->first();
        if($topic===null){
            $this->page404();
            return;
        }

        $counter = $topic->increaseCounter();
        $commentTree = $topic->getComments();

        // TODO use join
        foreach ($commentTree as $commentItem) {
            $commentItem['root']->user = User::get($commentItem['root']->userId);
            foreach ($commentItem['reply'] as $reply) {
                $reply->user = User::get($reply->userId);
            }
        }

        $data = array("topic" => $topic, "commentTree" => $commentTree, 'counter' => $counter);

        $replyTo = Rays::getParam('reply', null);
        if ($replyTo && is_numeric($replyTo)) {
            $comment = Comment::find($replyTo)->join("user")->first();
            $data['parent'] = $comment;
        }

        $data['canEdit'] = (Rays::isLogin() && (Rays::user()->id == $topic->user->id || Rays::user()->isAdmin()));

        $this->setHeaderTitle($topic->title);
        $this->addCss('/public/css/post.css');
        $this->render("view", $data, false);

    }

    /* Add comment */
    public function actionComment($topicId)
    {
        $topic = Topic::get($topicId);

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
            $topic->save();

            $user = Rays::user();

            $comment = new Comment();
            $comment->topicId = $topicId;
            $comment->userId = $user->id;
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
                Message::sendMessage(
                    'user',
                    $user->id,
                    $exactComment->userId,
                    'New reply',
                    $user->name . ' has replied to your comment ' . RHtmlHelper::linkAction('post', $topic->title, 'view', $topic->id . '?reply=' . $cid),
                    date('Y-m-d H:i:s')
                );
            } //send message to topic author
            else if ($topic->userId !== $user->id) {
                Message::sendMessage(
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

    public function actionDelete($topicId)
    {
        $topic = Topic::get($topicId);
        if($topic===null){
            $this->flash("message","No such topic!");
        }
        else{
            $topic->delete();
            $this->flash("message", "Post " . $topic->title . " was deleted.");
        }
        if($url = Rays::getParam("returnUrl",null))
            $this->redirect($url);
        else
            $this->redirect(Rays::referrerUri());
    }

    /**
     * Topics administration
     */
    public function actionAdmin() {
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

        $count = Topic::find()->count();;
        $data['count'] = $count;

        $query = Topic::find()->join("user")->join("group")->join("rating")->join("counter");
        $orderBy = Rays::getParam("orderBy","id");
        $order = Rays::getParam("order","desc");
        switch($orderBy){
            case "id": $query = $query->order($order, "[Topic.id]"); break;
            case "likes": $query = $query->order($order, "[RatingStatistic.value]"); break;
            case "views": $query = $query->order($order, "[Counter.totalCount]"); break;
            case "createTime": $query = $query->order($order, "[Topic.id]"); break;
            default:
                $query = $query->order_desc("id");
        }
        $posts = $query->range(($curPage-1)*$pageSize,$pageSize);
        $data['topics'] = $posts;
        $pager = new RPagerHelper('page', $count, $pageSize, RHtmlHelper::siteUrl("post/admin?orderBy=$orderBy&&order=$order"), $curPage);
        $pager = $pager->showPager();
        $data['pager'] = $pager;

        $this->render('admin', $data, false);
    }

    /**
     * Find posts
     */
    public function actionFind($categoryId = null)
    {
        $data = [];

        $category = new Category();
        if (isset($categoryId) && (!is_numeric($categoryId) || ($category=Category::get($categoryId)) === null)) {
            $this->page404();
            return;
        } else {
            $data['category'] = $category;
            $data['subs'] = $category->children();
        }

        $page = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize", 10);

        $count = 0;
        $cat = new Category();
        if ($categoryId === null) {
            $count = $cat->getActivePostsCount();
            $data['posts'] = $cat->getActivePosts(null, ($page - 1) * $pageSize, $pageSize);
        } else {
            $count = $cat->getActivePostsCount($categoryId);
            $data['posts'] = $cat->getActivePosts($categoryId, ($page - 1) * $pageSize, $pageSize);
        }

        if ($count > $pageSize) {
            $url = RHtmlHelper::siteUrl("post/find" . ($categoryId != null ? ("/" . $categoryId) : ""));
            $pager = new RPagerHelper("page", $count, $pageSize, $url, $page);
            $data['pager'] = $pager->showPager();
        }

        $this->setHeaderTitle("Find posts");
        $this->addCss("/public/css/post.css");
        $this->addCss("/public/css/group.css");
        $this->render('find', $data, false);
    }
}
