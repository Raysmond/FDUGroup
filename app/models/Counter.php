<?php
/**
 * Counter model
 * @author: Raysmond
 */

class Counter extends RModel{
    public $entityType;
    public $id,$entityId,$entityTypeId,$totalCount,$dayCount,$weekCount,$timestamp;

    public static $table = "counter";
    public static $primary_key = "id";

    public static $mapping = array(
        "id" => "cid",
        "entityId" => "entity_id",
        "entityTypeId" => "entity_type_id",
        "totalCount" => "totalcount",
        "dayCount" => "daycount",
        "weekCount" => "weekcount",
        "timestamp" => "timestamp",
    );


    public function loadCounter($entityId,$entityTypeId){
        if(is_numeric($entityId)&&is_numeric($entityTypeId)){
            $result = Counter::find("entityId",$entityId)->find("entityTypeId",$entityTypeId)->first();
            if($result===null){
                return null;
            }
            else{
                $result->entityType = new EntityType();
                $result->entityType->typeId = $this->entityTypeId;
                if($result->checkCounter()) $result->save();
                return $result;
            }
        }
        else{
            return null;
        }
    }

    public function increaseCounter($entityId,$entityTypeId){
        if(is_numeric($entityId)&&is_numeric($entityTypeId)){
            $result = Counter::find("entityId",$entityId)->find("entityTypeId",$entityTypeId)->first();
            if($result===null){
                $this->timestamp = date('Y-m-d H:i:s');
                $this->totalCount = 1;
                $this->dayCount = 1;
                $this->weekCount = 1;
                $this->save();
            }
            else{
                foreach(static::$mapping as $col=>$dbCol){
                    $this->$col = $result->$col;
                }
                $this->checkCounter();
                $this->totalCount++;
                $this->dayCount++;
                $this->weekCount++;
                $this->timestamp = date('Y-m-d H:i:s');
                $this->save();
            }
        }
    }

    public function checkCounter(){
        $needToUpdate = false;
        if(isset($this->timestamp)){
            $today = date('Y-m-d 00:00:00');
            if($this->timestamp<$today){
                $this->dayCount = 0;
                $needToUpdate = true;
            }
            $lastDay = date("Y-m-d",strtotime("$today Sunday"));
            $firstDay = date("Y-m-d 00:00:00",strtotime("$lastDay -6 days"));
            if($this->timestamp<$firstDay){
                $this->weekCount = 0;
                $needToUpdate = true;
            }
        }
        return $needToUpdate;
    }
} 