<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
class AdsController extends RController {
    public $layout = "user";
    public $defaultAction = "view";

    public $access = [
        Role::VIP => ['view', 'remove'],
        Role::ADMINISTRATOR => ['admin'],
    ];

    public function actionView($type='active') {
        $this->setHeaderTitle('My Advertisements');
        $currentUserId = Rays::app()->getLoginUser()->id;

        if ($type === 'active') {
            $data['ads'] = (new Ads())->getUserAds($currentUserId, Ads::NORMAL);
            $data['type'] = Ads::NORMAL;
        } else {
            $data['ads'] = (new Ads())->getUserAds($currentUserId, Ads::REMOVED);
            $data['type'] = Ads::REMOVED;
        }

        $this->render('view', $data, false);
    }

    public function actionRemove($adId = null, $type) {
        if (!isset($adId) || !is_numeric($adId)) {
            return;
        }
        $currentUserId = Rays::app()->getLoginUser()->id;
        $ad = new Ads();
        $ad->id = $adId;
        $ad = $ad->load();
        if ($ad !== null) {
            if ($ad->userId == $currentUserId) {
                $ad->delete();

                $this->flash('message', 'Advertisement removed successfully.');
                $this->redirectAction('ads', 'view', $type == Ads::NORMAL?'active':'blocked');
                return;
            } else {
                die('Permission denied');
            }
        } else {
            Rays::app()->page404();
        }
    }

    public function actionAdmin() {
        $this->setHeaderTitle('Advertisement');
        $this->layout = 'admin';
        $data = [];

        if ($this->getHttpRequest()->isPostRequest()) {
            if (isset($_POST['checked_ads'])) {
                $selected = $_POST['checked_ads'];
                if (is_array($selected)) {
                    $operation = $_POST['operation_type'];
                    foreach ($selected as $id) {
                        $ad = new Ads();
                        switch ($operation) {
                            case "block":
                                $ad->block($id);
                                break;
                            case "active":
                                $ad->activate($id);
                                break;
                        }
                    }
                }
            }
        }

        $filterStr = $this->getHttpRequest()->getParam('search', null);

        $like = array();
        if ($filterStr != null) {
            $data['filterStr'] = $filterStr;
            if (($str = trim($filterStr)) != '') {
                $names = explode(' ', $str);
                foreach ($names as $val) {
                    array_push($like, array('key' => 'title', 'value' => $val));
                }
            }
        }

        $ad = new Ads();
        $count = $ad->count($like);
        $data['count'] = $count;

        $curPage = $this->getHttpRequest()->getQuery('page', 1);
        $pageSize = (isset($_GET['pagesize']) && is_numeric($_GET['pagesize'])) ? $_GET['pagesize'] : 10;
        $ads = new Ads();
        $ads = $ads->find(($curPage - 1) * $pageSize, $pageSize, array('key' => $ads->columns["id"], "order" => 'desc'), $like);
        foreach ($ads as $ad) {
            $ad->load();
        }
        $data['ads'] = $ads;

        $url = RHtmlHelper::siteUrl('ads/admin');
        if ($filterStr != null) $url .= '?search=' . urlencode(trim($filterStr));

        $pager = new RPagerHelper('page', $count, $pageSize, $url, $curPage);
        $data['pager'] = $pager->showPager();

        $this->render('admin', $data, false);
    }
}