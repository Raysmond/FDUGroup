<?php
/**
 * Created by PhpStorm.
 * User: songrenchu
 */
class AdsController extends RController {
    public $access = [
        Role::VIP => ['view'],
    ];

    public function actionView() {
        echo 1;
    }
}