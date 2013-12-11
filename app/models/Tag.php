<?php
/**
 * Class Tag
 * @author: Raysmond
 */

class Tag extends RModel{

    public $type;
    public $id,$tagName,$entityTypeId,$entityId;

    public static $table = "id";
    public static $mapping = array(
        "tagId" => "tag_id",
        "tagName" =>"tag_name",
        "entityTypeId" => "entity_type",
        "entityId" => "entity_id",
    );

    public static $relation = array(
        'type'=>array('entityTypeId','EntityType','typeId')
    );

}