<?php
/**
 * Class User
 * @author: Raysmond
 */

class User extends Data{
    public static $roles = array('administrator','authenticated user','anonymous user');

    public $id,$roleId,$name,$mail,$password,$region,$mobile,$qq,$weibo;
    public $registerTime,$status,$picture,$intro,$homepage,$credits,$permission,$privacy;

    public $role;

    public $defaults = array(
        'status'=>1,
        'credits'=>1,
        'roleId'=>2
    );

    public function __construct(){
        $option = array(
            "key" => "id",
            "table" => "users",
            "columns" => array(
                "id" => "u_id",
                'roleId'=>'u_role_id',
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

    public function load($id=null)
    {
        parent::load($id);
        $this->role = new Role();
        $this->role->roleId = $this->roleId;
    }

    public function setDefaults()
    {
        foreach($this->defaults as $key=>$val){
            if(!isset($this->$key))
                $this->$key = $val;
        }
        if(!isset($this->registerTime)){
            date_default_timezone_set(Rays::app()->getTimeZone());
            $this->registerTime = date('Y-m-d H-i-s');
        }
    }

    public function countUnreadMsgs()
    {
        if(!isset($this->id))
            return 0;
        $msg = new Message();
        return $msg->countUnreadMsgs($this->id);
    }

    /**
     * Register a new user and return the new user object
     * @param $name
     * @param $password
     * @param $email
     */
    public function register($name,$password,$email)
    {
        $this->setDefaults();
        $this->name = $name;
        $this->password = $password;
        $this->mail = $email;
        $id = $this->insert();
        $this->load($id);
    }
}
