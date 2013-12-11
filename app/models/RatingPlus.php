<?php
/**
 * RatingPlus model.
 * It's not a basic data model. Both Rating and RatingStatistic data model are used here to generate a logical model
 * aiming to provide 'plus'(or 'like') functionality model.
 *
 * @author: Raysmond
 */

class RatingPlus
{
    public $entityType = null, $entityId = null, $userId = 0, $host;
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
            $rating = Rating::find("tag", self::TAG)->find("valueType", self::VALUE_TYPE)->find("value", self::VALUE);
            $rating = $rating->find("entityId", $this->entityId)->find("entityType", $this->entityType)->find("userId", $this->userId);
            $rating = $rating->first();
            if ($rating == null) {
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
                if (isset($rating->id) && $rating->id) {
                    $this->updatePlusCounter();
                    return true;
                }

            }
        }
        return false;
    }

    public static function countUserPostsPlus($userId)
    {
        return Rating::find(["entityType", Topic::ENTITY_TYPE, "userId", $userId, "valueType", self::VALUE_TYPE, "value", self::VALUE, "tag", self::TAG])->count();
    }

    public static function getUserPlusTopics($userId, $start = 0, $limit = 0)
    {
        $ratings = Rating::find(["entityType", Topic::ENTITY_TYPE, "userId", $userId, "valueType", self::VALUE_TYPE, "value", self::VALUE, "tag", self::TAG])->all();
        if ($ratings == null || empty($ratings))
            return array();

        $query = Topic::find()->join("user")->join("group")->order_desc("id");
        if ($ratings != null && !empty($ratings)) {
            $where = "[id] in (";
            $args = array();
            for ($count = count($ratings), $i = 0; $i < $count; $i++) {
                $where .= "?" . (($i < $count - 1) ? "," : "");
                $args[] = $ratings[$i]->entityId;
            }
            unset($ratings);
            $where .= ")";
            $query = $query->where($where, $args);
        }
        return ($start != 0 || $limit != 0) ? $query->range($start, $limit) : $query->all();
    }

    /**
     * Plus counter for every plus rating
     */
    private function updatePlusCounter()
    {
        $result = RatingStatistic::find(["type", "count", "valueType", self::VALUE_TYPE, "tag", self::TAG, "entityType", $this->entityType, "entityId", $this->entityId])->first();

        if ($result == null) {
            $result = new RatingStatistic();
            $result->entityType = $this->entityType;
            $result->entityId = $this->entityId;
            $result->type = "count";
            $result->value = 1;
            $result->valueType = self::VALUE_TYPE;
            $result->tag = self::TAG;
            $result->timestamp = date('Y-m-d H:i:s');
            $result->save();
        } else {
            $result->value++;
            $result->timestamp = date('Y-m-d H:i:s');
            $result->save();
        }
        $this->_counter = $result;
    }

    public function getCounter()
    {
        if ($this->_counter === null) {
            $result = RatingStatistic::find(["type", "count", "valueType", self::VALUE_TYPE, "tag", self::TAG, "entityType", $this->entityType, "entityId", $this->entityId])->first();
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

    /**
     * Delete plus-rating data
     */
    public function delete(){
        if (isset($this->entityType) && isset($this->entityId)) {
            // delete all rating records
            $ratings = Rating::find(["tag", self::TAG, "valueType", self::VALUE_TYPE,'entityId', $this->entityId,"entityType", $this->entityType])->all();
            foreach($ratings as $item){
                $item->delete();
            }

            // delete rating counting statistic
            $stat = RatingStatistic::find(["type", "count", "valueType", self::VALUE_TYPE, "tag", self::TAG, "entityType", $this->entityType, "entityId", $this->entityId])->first();
            if($stat!==null){
                $stat->delete();
            }
        }
    }
} 