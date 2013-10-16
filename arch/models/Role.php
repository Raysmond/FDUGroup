<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 * Date: 13-10-15
 * Time: PM3:11
 * To change this template use File | Settings | File Templates.
 */

class Role extends Data{
    const ADMINISTRATOR = 'administrator';
    const ANONYMOUS = 'anonymous';
    const AUTHENTICATED = 'authenticated';

    const ADMINISTRATOR_ID = 1;
    const AUTHENTICATED_ID = 2;
    const ANONYMOUS_ID = 3;

    //const VIP_USER = 4;

    public $roleId,$roleName;

    public function __construct()
    {
        $option = array(
            'key'=>'roleId',
            'table'=>'user_role',
            'columns'=>array(
                'roleId'=>'rol_id',
                'roleName'=>'rol_name'
            )
        );
        parent::init($option);
    }


}