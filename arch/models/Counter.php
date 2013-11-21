<?php
/**
 * Counter model
 * @author: Raysmond
 */

class Counter extends Data{
    public $entityType;
    public $id,$entityId,$entityTypeId,$totalCount,$dayCount,$weekCount,$timestamp;

    public function __construct(){
        $option = array(
            "key" => "id",
            "table" => "counter",
            "columns" => array(
                "id" => "cid",
                "entityId" => "entity_id",
                "entityTypeId" => "entity_type_id",
                "totalCount" => "totalcount",
                "dayCount" => "daycount",
                "weekCount" => "weekcount",
                "timestamp" => "timestamp",
            )
        );
        parent::init($option);
    }

    public function load($id = null){
        $result = parent::load($id);
        if($result===null) return null;
        $this->entityType = new EntityType();
        $this->entityType->load($this->entityTypeId);
        return $this;
    }

    public function loadCounter($entityId,$entityTypeId){
        if(is_numeric($entityId)&&is_numeric($entityTypeId)){
            $this->entityId = $entityId;
            $this->entityTypeId = $entityTypeId;
            $result = $this->find();
            if($result===null||count($result)==0){
                return null;
            }
            else{
                $result[0]->entityType = new EntityType();
                $result[0]->entityType->load($this->entityTypeId);
                return $result[0];
            }
        }
    }

    public function increaseCounter($entityId,$entityTypeId){
        if(is_numeric($entityId)&&is_numeric($entityTypeId)){
            $this->entityId = $entityId;
            $this->entityTypeId = $entityTypeId;
            $result = $this->find();
            if($result===null||count($result)==0){
                return false;
            }
            else{
                $result = $result[0];
                foreach($this->columns as $col){
                    $this->$col = $result->$col;
                }
                $this->checkCounter();
                $this->totalCount++;
                $this->dayCount++;
                $this->weekCount++;
                $this->update();
                return true;
            }
        }
    }

    public function checkCounter(){
        if(isset($this->timestamp)){
            $today = date('Y-m-d 00:00:00');
            if($this->timestamp<$today){
                $this->dayCount = 0;
            }
            $lastDay = date("Y-m-d",strtotime("$today Sunday"));
            $firstDay = date("Y-m-d 00:00:00",strtotime("$lastDay -6 days"));
            if($this->timestamp<$firstDay){
                $this->weekCount = 0;
            }
        }
    }
} 