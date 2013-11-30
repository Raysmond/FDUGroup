<?php
/**
 * MessageType model class file.
 * @author: songrenchu
 */

class CensorType extends Data{
    public $typeId,$typeName;

    public function __construct()
    {
        $option = array(
            "key" => "typeId",
            "table" => "censor_type",
            "columns" => array(
                "typeId" => "csr_type_id",
                "typeName" => "csr_type_name"
            )
        );
        parent::init($option);
    }

}