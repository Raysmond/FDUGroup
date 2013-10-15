<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Raysmond
 * Date: 13-10-15
 * Time: PM3:11
 * To change this template use File | Settings | File Templates.
 */

class Role extends Data{
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