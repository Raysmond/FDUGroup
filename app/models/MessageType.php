<?php
/**
 * MessageType model class file.
 * @author: Raysmond
 */

class MessageType extends Data{
    public $typeId,$typeName;

    public function __construct()
    {
        $option = array(
            "key" => "typeId",
            "table" => "message_type",
            "columns" => array(
                "typeId" => "msg_type_id",
                "typeName" => "msg_type_name"
            )
        );
        parent::init($option);
    }

}