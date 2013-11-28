<?php
/**
 * AdminController class file.
 * @author: Raysmond
 */

class AdminController extends BaseController{
    public $layout = 'admin';
    public $defaultAction = 'index';
    public $access = array(Role::ADMINISTRATOR=>array('index','logs'));

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
        $data = array();

        $curPage = $this->getHttpRequest()->getQuery('page',1);
        $pageSize = (isset($_GET['pagesize'])&&is_numeric($_GET['pagesize']))?$_GET['pagesize'] : 8;
        $count = new SystemLog();
        $count = $count->count();

        $url = RHtmlHelper::siteUrl('admin/logs');
        $pager = new RPagerHelper('page',$count,$pageSize,$url,$curPage);
        $data['pager'] = $pager->showPager();
        $data['count'] = $count;

        $sysLogs = new SystemLog();
        $logs = $sysLogs->find(($curPage-1)*$pageSize,$pageSize,['key'=>$sysLogs->columns['id'],'order'=>'desc']);

        $data['logs'] = $logs;
        $this->setHeaderTitle("System logs");
        $this->render('logs',$data,false);
    }
}