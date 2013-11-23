<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
class AdsController extends RController {
    public $layout = "user";
    public $defaultAction = "view";

    public $access = [
        Role::VIP => ['view','apply','remove'],
        Role::ADMINISTRATOR => ['approve']
    ];

    public function actionView($type='active') {
        $this->setHeaderTitle('My Advertisements');
        $currentUserId = Rays::app()->getLoginUser()->id;

        $ads = new Ads();
        if ($type === 'applying') {
            $data['ads'] = $ads->getUserAds($currentUserId, Ads::APPLYING);
            $data['type'] = Ads::APPLYING;
        } else if($type === 'blocked'){
            $data['ads'] = $ads->getUserAds($currentUserId, Ads::REMOVED);
            $data['type'] = Ads::REMOVED;
        } else if($type === 'published'){
            $data['ads'] = $ads->getUserAds($currentUserId, Ads::APPROVED);
            $data['type'] = Ads::APPROVED;
        } else{
            Rays::app()->page404();
            return;
        }

        $this->render('view', $data, false);
    }

    public function actionApply(){
        $data = array();
        if($this->getHttpRequest()->isPostRequest()){
            $rules = array(
                array('field'=>'ads-title','label'=>'Ads title','rules'=>'trim|required|min_length[5]|max_length[255]'),
                array('field'=>'ads-content','label'=>'Ads content','rules'=>'required'),
                array('field'=>'paid-price','label'=>'Paid price','rules'=>'trim|required|number'),
            );
            $validation = new RFormValidationHelper($rules);
            if($validation->run()){
                $ads = new Ads();
                $result = $ads->apply(
                    Rays::app()->getLoginUser()->id,
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

    /**
     * Approved ads can appear on some positions within appointed pages
     * @access administrator
     */
    public function actionApprove($adId=''){
        if(!isset($adId) || !is_numeric($adId)){
            Rays::app()->page404();
            return;
        }
        $ad = new Ads();
        $ad->id = $adId;
        $ad = $ad->load();
        if ($ad !== null) {
            $ad->approve();
            $this->flash('message','Ads approved.');
        } else {
            Rays::app()->page404();
        }
    }
}