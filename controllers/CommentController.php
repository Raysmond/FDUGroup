<?php
/**
 * CommentController class file.
 *
 * @author: Raysmond
 */

class CommentController extends BaseController
{
    public $layout = "index";
    public $defaultAction = "index";

    public $access = array(
        Role::ADMINISTRATOR => array('admin'),
    );

    public function actionAdmin()
    {
        // delete comment request
        if (Rays::isPost()) {
            if (isset($_POST['checked_comments'])) {
                $commentIds = $_POST['checked_comments'];
                foreach ($commentIds as $id) {
                    if (!is_numeric($id)) return;
                    else {
                        $comment = new Comment();
                        $comment->id = $id;
                        $comment->delete();
                    }
                }
            }
        }

        $curPage = $this->getPage("page");
        $pageSize = $this->getPageSize('pagesize',10);

        $count = Comment::find()->count();
        $comments = Comment::find()->join("user")->join("topic")->order_desc("id")->range(($curPage - 1) * $pageSize, $pageSize);
        $pager = new RPager('page', $count, $pageSize, RHtml::siteUrl('comment/admin'), $curPage);

        $this->layout = 'admin';
        $this->setHeaderTitle("Comments administration");
        $data = array('count'=>$count,'comments'=>$comments,'pager'=>$pager->showPager());
        $this->render('admin', $data, false);
    }
} 