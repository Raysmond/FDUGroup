<?php
/**
 * Data model for user role, e.g. normal user, administrators
 * @author Raysmond, Xiangyan Sun
 */

class Role extends RModel
{
    const ADMINISTRATOR = 'administrator';
    const ANONYMOUS = 'anonymous';
    const AUTHENTICATED = 'authenticated';
    const VIP = 'vip';

    const ADMINISTRATOR_ID = 1;
    const AUTHENTICATED_ID = 2;
    const ANONYMOUS_ID = 3;
    const VIP_ID = 4;

    public static $Roles = array('administrator','authenticated','anonymous', 'vip');
    public static $Roles_Badge = array('Admin', 'Grouper', 'Guest', 'VIP Grouper');

    public static function getRoleNameById($roleId){
        switch($roleId){
            case 1 : return self::$Roles[0];
            case 2: return self::$Roles[1];
            case 3: return self::$Roles[2];
            case 4: return self::$Roles[3];
            default: return self::$Roles[2];
        }
    }

    public static function getBadgeById($roleId) {
        switch($roleId){
            case 1 : return self::$Roles_Badge[0];
            case 2: return self::$Roles_Badge[1];
            case 3: return self::$Roles_Badge[2];
            case 4: return self::$Roles_Badge[3];
            default: return self::$Roles_Badge[2];
        }
    }

    public $id, $name;

    public static $primary_key = "id";
    public static $table = "user_role";
    public static $mapping = array(
        "id" => "rol_id",
        "name" => "rol_name"
    );
}
