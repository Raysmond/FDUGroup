<?php
/**
 * MessageType model class file.
 *
 * @author: songrenchu
 */

class CensorType extends RModel{
    public $typeId,$typeName;

    public static $table = "censor_type";
    public static $primary_key = "typeId";
    public static $mapping = array(
        "typeId" => "csr_type_id",
        "typeName" => "csr_type_name"
    );
}