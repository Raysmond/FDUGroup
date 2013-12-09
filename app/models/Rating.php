<?php
/**
 * Rating data model class file.
 * @author: Raysmond
 */

class Rating extends RModel
{

    public $id, $entityType, $entityId, $valueType, $value = 0, $tag, $userId = 0, $host, $timestamp;

    public static $table = "rating";
    public static $primary_key = "id";
    public static $mapping = array(
        "id" => "rating_id",
        'entityType' => 'entity_type',
        "entityId" => "entity_id",
        "valueType" => "value_type",
        "value" => "value",
        "tag" => "tag",
        "userId" => "u_id",
        "host" => "host",
        "timestamp" => "timestamp"
    );
}