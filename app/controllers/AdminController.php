<?php
/**
 * AdminController class file.
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

        $count = (new SystemLog())->count();
        $pager = new RPagerHelper('page', $count, $pageSize, RHtmlHelper::siteUrl('admin/logs'), $curPage);

        $sysLogs = new SystemLog();
        $logs = $sysLogs->find(($curPage - 1) * $pageSize, $pageSize, ['key' => $sysLogs->columns['id'], 'order' => 'desc']);

        $this->setHeaderTitle("System logs");
        $this->render('logs', ['logs' => $logs, 'pager' => $pager->showPager(), 'count' => $count], false);
    }
}