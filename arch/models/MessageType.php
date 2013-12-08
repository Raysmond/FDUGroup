<?php
/**
 * MessageType data model
 * @author: Raysmond, Xiangyan Sun
 */

class MessageType extends RModel {
    public $id, $name;

    public static $primary_key = "id";
    public static $table = "message_type";
    public static $mapping = array(
        "id" => "msg_type_id",
        "name" => "msg_type_name"
    );
}