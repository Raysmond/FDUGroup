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

    const VALUE_TYPE = 'integer';
    const TAG = "plus";
    const VALUE = 1;

    public function __construct($entityType, $entityId, $userId,$host)
    {
        $this->entityType = $entityType;
        $this->entityId = $entityId;
        $this->userId = $userId;
        $this->host = $host;
    }

    public function rate()
    {
        if ($this->check()) {
            $plus = new Rating();
            $plus->entityId = $this->entityId;
            $plus->entityType = $this->entityType;
            $plus->userId = $this->userId;
            $plus->host = $this->host;
            $plus->valueType = self::VALUE_TYPE;
            $plus->value = self::VALUE;
            $plus->tag = self::TAG;
            if(count($plus->find())==0){
                $ratingId = $plus->insert();
                if ($ratingId !== null && is_numeric($ratingId)) {
                    $this->_ratingId = $ratingId;
                    return true;
                }
            }
        }
        return false;
    }

    public function getRating()
    {
        if ($this->_ratingId !== null && $this->_rating === null) {
            $this->_rating = new Rating();
            $this->_rating->id = $this->_ratingId;
            $result = $this->_rating->load();
            if ($result !== null) {
                $this->_rating = $result;
            } else {
                $this->_rating = null;
            }
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