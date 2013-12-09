<?php
/**
 * Data model for users
 * @author: Raysmond, Xiangyan Sun
 */

class User extends RModel
{
    public static $roles = array('administrator', 'authenticated user', 'anonymous user', 'VIP user');

    public $id, $roleId, $name, $mail, $password, $region, $mobile, $qq, $weibo;
    public $registerTime, $status, $picture, $intro, $homepage, $credits, $gender, $privacy;

    public $role;
    private $_wallet;

    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;

    const ENTITY_TYPE = 4;

    public static $labels = array(
        "id" => "ID",
        'roleId' => 'Role',
        "name" => "Name",
        "mail" => "Mail",
        "password" => "Password",
        "region" => "Region",
        "mobile" => "Mobile",
        "qq" => "QQ",
        "weibo" => "Weibo",
        "registerTime" => "Register time",
        "status" => "Status",
        "picture" => "Picture",
        "intro" => "Introduction",
        "homepage" => "Homepage",
        "credits" => "Credits",
        "gender" => "Gender",
        "privacy" => "Privacy",
    );

    public static $defaults = array(
        'status' => self::STATUS_ACTIVE,
        'credits' => 1,
        'roleId' => Role::AUTHENTICATED_ID,
        'picture' => 'public/images/default_pic.png',
        'gender' => 0
    );

    public static $primary_key = "id";
    public static $table = "users";
    public static $mapping = array(
        "id" => "u_id",
        'roleId' => 'u_role_id',
        "name" => "u_name",
        "mail" => "u_mail",
        "password" => "u_password",
        "region" => "u_region",
        "mobile" => "u_mobile",
        "qq" => "u_qq",
        "weibo" => "u_weibo",
        "registerTime" => "u_register_time",
        "status" => "u_status",
        "picture" => "u_picture",
        "intro" => "u_intro",
        "homepage" => "u_homepage",
        "credits" => "u_credits",
        "gender" => "u_gender",
        "privacy" => "u_privacy",
    );

    public static function getGenderName($genderId)
    {
        switch ($genderId) {
            case 1:
                return "Male";
                break;
            case 2:
                return "Female";
                break;
            default:
                return "Unknown";
        }
    }

    /**
     * Get user wallet, create a wallet for the user if no wallet is found
     * @return null|Wallet
     */
    public function getWallet()
    {
        if ($this->_wallet instanceof Wallet)
            return $this->_wallet;
        else {
            $this->_wallet = null;
            if (isset($this->id) && is_numeric($this->id)) {
                $this->_wallet = new Wallet();
                $this->_wallet->userId = $this->id;
                $result = $this->_wallet->load();
                if ($result === null) {
                    $this->_wallet->timestamp = date('Y-m-d H:i:s');
                    $this->_wallet->insert();
                    $this->_wallet->load();
                }
            }
            return $this->_wallet;
        }
    }

    public function setDefaults()
    {
        foreach (self::$defaults as $key => $val) {
            if (!isset($this->$key))
                $this->$key = $val;
        }
        if (!isset($this->registerTime)) {
            $this->registerTime = date('Y-m-d H-i-s');
        }
    }

    public function countUnreadMsgs()
    {
        if (!isset($this->id))
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
    public function register($name, $password, $email)
    {
        $this->setDefaults();
        $this->name = $name;
        $this->password = $password;
        $this->mail = $email;
        $id = $this->insert();
        $this->load($id);
    }

    public static function countPosts($userId){
        return Topic::find("userId",$userId)->count();
    }

    public static function countFriends($userId)
    {
        return Friend::find("uid",$userId)->count();
    }

    public static function countGroups($userId)
    {
        return GroupUser::find("userId",$userId)->count();
    }

    /* TODO: Should not pass postForm here */
    public static function login($postForm) {
        $validation = new RFormValidationHelper(array(
            array('field' => 'username', 'label' => 'User name', 'rules' => 'trim|required'),
            array('field' => 'password', 'label' => 'password', 'rules' => 'trim|required')
        ));

        if ($validation->run()) {
            $login = User::verifyLogin($postForm['username'], $postForm['password']);
            if ($login instanceof User) {
                return $login;
            } else {
                return array('verify_error' => $login);
            }
        } else {
            return array('validation_errors' => $validation->getErrors());
        }
    }

    /**
     * Verify login information
     * @param $username
     * @param $password
     * @return string or User objetct
     */
    public static function verifyLogin($username, $password)
    {
        $user = User::find("name", $username)->first();
        if ($user == null)
            return "No such user name.";
        if ($user->status == self::STATUS_BLOCKED) {
            return "User with name " . $user->name . " has been blocked!";
        }
        if ($user->password == md5($password)) {
            return $user;
        } else return "User name and password not match!";
    }

    public function isAdmin()
    {
        if (isset($this->roleId)) {
            return $this->roleId == Role::ADMINISTRATOR_ID;
        }
    }

    public static function blockUser($userId) {
        $user = User::get($userId);
        if ($user != null) {
            $user->status = User::STATUS_BLOCKED;
            $user->save();
        }
    }

    public function activateUser($userId) {
        $user = User::get($userId);
        if ($user != null) {
            $user->status = User::STATUS_ACTIVE;
            $user->save();
        }
    }

    public function sendWelcomeMessage() {
        $title = "Welcome " . $this->name;
        $content = 'Dear '.$this->name." : <br/>"
            ."Welcome to join the FDUGroup big family!"
            .'<br/><br/>'
            ."--- <b>FDUGroup team</b>"
            .'<br/>'
            .date('Y-m-d H:i:s');
        Message::sendMsg('system', 0, $this->id, $title, RHtmlHelper::encode($content), null, 1);
    }

    public static function getPicOptions()
    {
        return array(
            'path' => 'files/images/styles',
            'name' => 'users',
            'width' => 200,
            'height' => 200
        );
    }
}
