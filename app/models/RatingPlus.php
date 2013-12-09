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
                $ratingId = $rating->save();
                if ($ratingId !== null && is_numeric($ratingId)) {
                    $this->_ratingId = $ratingId;
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
        $rating = $rating->find("entityType",Topic::$entityType)->find("userId",$userId);

        return $rating->count();
    }

    // todo
    public static function getUserPlusTopics($userId,$start=0,$limit=0)
    {
        $plus = new Rating();
        $plus->entityType = Topic::$entityType;
        $plus->userId = $userId;
        $plus->valueType = self::VALUE_TYPE;
        $plus->value = self::VALUE;
        $plus->tag = self::TAG;

        $topicList = $plus->find();
        $topicIdList = array_map(function ($value) {
            return $value->entityId;
        }, $topicList);

        $likeTopics = new Topic();
        if (count($topicList) > 0) {
            $likeTopics = $likeTopics->find($start, $limit,
                ['key' => $likeTopics->columns['id'], 'order' => 'desc'],
                null,
                ['id' => $topicIdList]
            );

            foreach($likeTopics as $item){
                $item->user = new User();
                $item->user->load($item->userId);
                $item->group = new Group();
                $item->group->load($item->groupId);
            }
        } else {
            $likeTopics = array();
        }

        return $likeTopics;
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