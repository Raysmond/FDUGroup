<?php
/**
 * AdminController class file.
 *
 * @author: Raysmond
 */

class AdminController extends BaseController
{
    public $layout = 'admin';
    public $defaultAction = 'index';
    public $access = array(Role::ADMINISTRATOR => array('index', 'logs'));

    public function actionIndex()
    {
        $this->setHeaderTitle("Administration");
        $this->render('index');
    }

    /**
     * View system logs
     */
    public function actionLogs()
    {
        $curPage = $this->getPage("page");
        $pageSize = $this->getPageSize("pagesize", 10);

        $count = SystemLog::find()->count();
        $logs = SystemLog::find()->order_desc("id")->join('user')->range(($curPage - 1) * $pageSize, $pageSize);

        $pager = new RPagerHelper('page', $count, $pageSize, RHtmlHelper::siteUrl('admin/logs'), $curPage);
        $this->setHeaderTitle("System logs");
        $this->render('logs', ['logs' => $logs, 'pager' => $pager->showPager(), 'count' => $count], false);
    }
}