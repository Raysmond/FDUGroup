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
}