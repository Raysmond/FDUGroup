<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
class AdsController extends BaseController {
    public $layout = "user";
    public $defaultAction = "view";

    public $access = [
        Role::VIP => ['view','apply','remove', 'edit'],
        Role::ADMINISTRATOR => ['approve','admin']
    ];

    public function actionView($type='active') {
        $this->setHeaderTitle('My Advertisements');
        $currentUserId = Rays::user()->id;

        $ads = new Ads();
        if($type === 'blocked'){
            $data['ads'] = $ads->getUserAds($currentUserId, Ads::BLOCKED);
            $data['type'] = Ads::BLOCKED;
        } else if($type === 'published'){
            $data['ads'] = $ads->getUserAds($currentUserId, Ads::APPROVED);
            $data['type'] = Ads::APPROVED;
        } else{
            $data['ads'] = $ads->getUserAds($currentUserId, Ads::APPLYING);
            $data['type'] = Ads::APPLYING;
        }

        $this->render('view', $data, false);
    }

    public function actionApply(){
        $data = array();
        if(Rays::isPost()){
            $rules = array(
                array('field'=>'ads-title','label'=>'Ads title','rules'=>'trim|required|min_length[5]|max_length[255]'),
                array('field'=>'ads-content','label'=>'Ads content','rules'=>'required'),
                array('field'=>'paid-price','label'=>'Paid price','rules'=>'trim|required|number'),
            );
            $validation = new RFormValidationHelper($rules);
            if($validation->run()){
                //Money cannot exceed wallet remaining
                $money = Rays::user()->getWallet()->money;
                if ($money<(int)$_POST['paid-price']) {
                    /* TODO 这个要整合到Validation里面去 to Raysmond */
                    $this->flash('error','You cannot overdraft your '.Wallet::COIN_NAME.' to publish advertisements.');
                    $data['applyForm'] = $_POST;
                } else {
                    Rays::user()->getWallet()->cutMoney((int)$_POST['paid-price']);      //Pay the price
                    $ads = new Ads();
                    $result = $ads->apply(
                        Rays::user()->id,
                        $_POST['ads-title'],
                        RHtmlHelper::encode($_POST['ads-content']),
                        $_POST['paid-price']
                    );
                    if($result==true){
                        $this->flash('message','Your ads was applied successfully.');
                    }
                    else{
                        $data['applyForm'] = $_POST;
                        $this->flash('message','Apply failed.');
                    }
                }


            }
            else{
                $data['applyForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $this->setHeaderTitle("Ads application");
        $this->render('apply',$data,false);
    }

    public function actionRemove($adId = null, $type) {
        if (!isset($adId) || !is_numeric($adId)) {
            return;
        }
        $currentUserId = Rays::user()->id;
        $ad = new Ads();
        $ad->id = $adId;
        $ad = $ad->load();
        if ($ad !== null) {
            if ($ad->userId == $currentUserId) {
                $ad->delete();

                $this->flash('message', 'Advertisement removed successfully.');
                $redirect = null;
                switch ($type) {
                    case Ads::APPROVED: $redirect = 'published';break;
                    case Ads::APPLYING: $redirect = 'applying';break;
                    case Ads::BLOCKED: $redirect = 'blocked';break;
                }
                $this->redirectAction('ads', 'view', $redirect);
                return;
            } else {
                die('Permission denied');
            }
        } else {
            $this->page404();
            return;
        }
    }

    public function actionEdit($adId, $type) {
        if(!isset($adId)||!is_numeric($adId)){
            $this->page404();
            return;
        }
        $data = array();
        $ad = new Ads();
        $ad->id = $adId;
        $result = $ad->load();

        if($result===null){
            $this->page404();
            return;
        }
        $data['ad'] = $ad;
        $data['edit'] = true;
        $data['type'] = $type;
        if(Rays::isPost()){
            $rules = array(
                array('field'=>'ads-title','label'=>'Ads title','rules'=>'trim|required|min_length[5]|max_length[255]'),
                array('field'=>'ads-content','label'=>'Ads content','rules'=>'required'),
                array('field'=>'paid-price','label'=>'Paid price','rules'=>'trim|required|number'),
            );
            $validation = new RFormValidationHelper($rules);
            if($validation->run()){
                $ads = new Ads();
                $ads->id = $adId;
                $ads->load();
                $ads->title = $_POST['ads-title'];
                $ads->content = RHtmlHelper::encode($_POST['ads-content']);
                $ads->update();
                $this->flash('message','Your ads was edited successfully.');
                $redirect = null;
                switch ($type) {
                    case Ads::APPROVED: $redirect = 'published';break;
                    case Ads::APPLYING: $redirect = 'applying';break;
                    case Ads::BLOCKED: $redirect = 'blocked';break;
                }
                $this->redirectAction('ads','view', $redirect);
            }
            else{
                $data['applyForm'] = $_POST;
                $data['validation_errors'] = $validation->getErrors();
            }
        }

        $this->setHeaderTitle("Edit Advertisement");
        $this->render('apply',$data,false);
    }

    public function actionAdmin() {
        $this->setHeaderTitle('Advertisement');
        $this->layout = 'admin';
        $data = [];

        if (Rays::isPost()) {
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

        $filterStr = Rays::getParam('search', null);

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

        $curPage = $this->getPage('page');
        $pageSize = $this->getPageSize("pagesize",10);
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

    public function actionHitAd() {
        if (Rays::isAjax()) {
            $adId = (int)$_POST['adId'];
            $ad = (new Ads())->load($adId);
            if ($ad !== null) {
                (new Counter())->increaseCounter($adId, Ads::ENTITY_ID);        //Ad访问计数器
                /** TODO 刷广告访问监测机制 */
                $user = (new User())->load($ad->userId);
                if ($user !== null) {
                    $wallet = $user->getWallet();                               //访问一次挣一元钱
                    $wallet->addMoney(1);
                }
            }
        }
    }
}