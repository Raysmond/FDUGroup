<?php
/**
 * CommentController class file.
 * @author: Raysmond
 */

class CommentController extends RController
{
    public $layout = "index";
    public $defaultAction = "index";

    public $access = array(
        Role::ADMINISTRATOR => array('admin'),
    );

    public function actionAdmin()
    {
        $this->layout = 'admin';
        $data = array();

        // delete comment request
        if ($this->getHttpRequest()->isPostRequest()) {
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

        $curPage = $this->getHttpRequest()->getQuery('page', 1);
        $pageSize = (isset($_GET['pagesize'])&&is_numeric($_GET['pagesize']))?$_GET['pagesize']:5;

        $rows = new Comment();
        $count = $rows->count();
        $data['count'] = $count;

        $comment = new Comment();
        $comment = $comment->findAll(($curPage - 1) * $pageSize, $pageSize,
            array('key' => 'id', "order" => 'desc'));
        $data['comments'] = $comment;

        $pager = new RPagerHelper('page', $count, $pageSize, RHtmlHelper::siteUrl('comment/admin'), $curPage);
        $data['pager'] = $pager->showPager();

        $this->render('admin', $data, false);
    }
} 