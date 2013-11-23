<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
class AdsController extends RController {
    public $layout = "user";
    public $defaultAction = "view";

    public $access = [
        Role::VIP => ['view'],
    ];

    public function actionView($type='active') {
        $this->setHeaderTitle('My Advertisements');
        $currentUserId = Rays::app()->getLoginUser()->id;
        $currentUserName = Rays::app()->getLoginUser()->name;

        if ($type === 'active') {
            $data['ads'] = (new Ads())->getUserAds($currentUserId, Ads::NORMAL);
            $data['type'] = Ads::NORMAL;
        } else {
            $data['ads'] = (new Ads())->getUserAds($currentUserId, Ads::REMOVED);
            $data['type'] = Ads::REMOVED;
        }

        $this->render('view', $data, false);
    }
}