<?php
/**
 * Rating statistic data model class file.
 * @author: Raysmond
 */

class RatingStatistic extends RModel
{

    public $id, $type, $entityType, $entityId, $valueType, $value = 0, $tag, $timestamp;

    public static $table = "rating_statistic";
    public static $mapping = array(
        "id" => "stat_id",
        'type' => 'stat_type',
        'entityType' => 'entity_type',
        "entityId" => "entity_id",
        "valueType" => "value_type",
        "value" => "value",
        "tag" => "tag",
        "timestamp" => "timestamp"
    );

    public function insert()
    {
        if (!isset($this->timestamp) || $this->timestamp === '') {
            $this->timestamp = date('Y-m-d H:i:s');
        }
        return parent::insert();
    }

}