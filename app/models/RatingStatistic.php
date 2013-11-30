<?php
/**
 * Rating statistic data model class file.
 * @author: Raysmond
 */

class RatingStatistic extends Data
{

    public $id, $type, $entityType, $entityId, $valueType, $value = 0, $tag, $timestamp;

    public function __construct()
    {
        $options = array(
            "key" => "id",
            "table" => "rating_statistic",
            "columns" => array(
                "id" => "stat_id",
                'type' => 'stat_type',
                'entityType' => 'entity_type',
                "entityId" => "entity_id",
                "valueType" => "value_type",
                "value" => "value",
                "tag" => "tag",
                "timestamp" => "timestamp"
            )
        );
        parent::init($options);
    }

    public function insert()
    {
        if (!isset($this->timestamp) || $this->timestamp === '') {
            $this->timestamp = date('Y-m-d H:i:s');
        }
        return parent::insert();
    }

}