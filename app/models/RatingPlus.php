<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-11-25
 * Time: PM12:45
 */

class RatingPlus
{
    public $entityType = null, $entityId = null, $userId = 0,$host;
    private $_rating = null;
    private $_ratingId = null;

    private $_counter = null;

    const VALUE_TYPE = 'integer';
    const TAG = "plus";
    const VALUE = 1;

    public function __construct($entityType, $entityId, $userId = 0, $host = "")
    {
        $this->entityType = $entityType;
        $this->entityId = $entityId;
        $this->userId = $userId;
        $this->host = $host;
    }

    public function rate()
    {
        if ($this->check()) {
            $rating = Rating::find("tag",self::TAG)->find("valueType",self::VALUE_TYPE)->find("value",self::VALUE);
            $rating = $rating->find("entityId",$this->entityId)->find("entityType",$this->entityType)->find("userId",$this->userId);
            $rating = $rating->first();
            if($rating==null){
                $rating = new Rating();
                $rating->tag = self::TAG;
                $rating->valueType = self::VALUE_TYPE;
                $rating->value = self::VALUE;
                $rating->host = $this->host;
                $rating->entityId = $this->entityId;
                $rating->entityType = $this->entityType;
                $rating->userId = $this->userId;
                $rating->timestamp = date('Y-m-d H:i:s');
                $rating->save();
                if(isset($rating->id)&&$rating->id){
                    $this->updatePlusCounter();
                    return true;
                }

            }
        }
        return false;
    }

    public static function countUserPostsPlus($userId)
    {
        $rating = Rating::find("tag",self::TAG)->find("valueType",self::VALUE_TYPE)->find("value",self::VALUE);
        $rating = $rating->find("entityType",Topic::ENTITY_TYPE)->find("userId",$userId);

        return $rating->count();
    }

    public static function getUserPlusTopics($userId,$start=0,$limit=0)
    {
        $ratings = Rating::find("entityType",Topic::ENTITY_TYPE)->find("userId",$userId)->find("valueType",self::VALUE_TYPE)->find("value",self::VALUE)->find("tag",self::TAG)->all();
        if($ratings==null || empty($ratings))
            return array();

        $query = Topic::find()->join("user")->join("group")->order_desc("id");
        if($ratings!=null&&!empty($ratings)){
            $where = "[id] in (";
            $args = array();
            for($count = count($ratings),$i = 0;$i<$count;$i++){
                $where.="?".(($i<$count-1)?",":"");
                $args[] = $ratings[$i]->entityId;
            }
            unset($ratings);
            $where.=")";
            $query = $query->where($where,$args);
        }

        return $query->all();
    }

    /**
     * Plus counter for every plus rating
     */
    private function updatePlusCounter(){
        $result = RatingStatistic::find("type","count")->find("valueType",self::VALUE_TYPE)->find("tag",self::TAG);
        $result = $result->find("entityType",$this->entityType)->find("entityId",$this->entityId)->first();

        if($result==null){
            $result = new RatingStatistic();
            $result->entityType = $this->entityType;
            $result->entityId = $this->entityId;
            $result->type = "count";
            $result->value = 1;
            $result->valueType = self::VALUE_TYPE;
            $result->tag = self::TAG;
            $result->timestamp = date('Y-m-d H:i:s');
            $result->save();
        }
        else{
            $result->value++;
            $result->timestamp = date('Y-m-d H:i:s');
            $result->save();
        }
        $this->_counter = $result;
    }

    public function getCounter(){
        if($this->_counter===null){
              $result = RatingStatistic::find("type","count")->find("valueType",self::VALUE_TYPE)->find("tag",self::TAG);
              $result = $result->find("entityType",$this->entityType)->find("entityId",$this->entityId)->first();
              $this->_counter = $result;
        }
        return $this->_counter;
    }

    public function getRating()
    {
        if ($this->_ratingId !== null && $this->_rating === null) {
            $this->_rating = Rating::get($this->_ratingId);
        }
        return $this->_rating;
    }

    private function check()
    {
        if (isset($this->entityType) && isset($this->entityId)) {
            if (is_numeric($this->entityId) && is_numeric($this->entityType) && is_numeric($this->userId))
                return true;
        }
        return false;
    }
} 