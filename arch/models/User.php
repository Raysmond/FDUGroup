<?php
/**
 * Class User
 * @author: Raysmond
 */

class User extends Data{
    public $id,$name,$mail,$password,$region,$mobile,$qq,$weibo;
    public $registerTime,$status,$picture,$intro,$homepage,$credits,$permission,$privacy;

    public function __construct(){
        $option = array(
            "key" => "id",
            "table" => "users",
            "columns" => array(
                "id" => "u_id",
                "name" => "u_name",
                "mail" => "u_mail",
                "password" => "u_password",
                "region" => "u_region",
                "mobile" => "u_mobile",
                "qq" => "u_qq",
                "weibo" => "u_weibo",
                "registerTime"=>"u_register_time",
                "status" => "u_status",
                "picture" => "u_picture",
                "intro" => "u_intro",
                "homepage" =>"u_homepage",
                "credits" => "u_credits",
                "permission" => "u_permission",
                "privacy" => "u_privacy",
            )
        );
        parent::init($option);
    }


}
