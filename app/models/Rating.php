<?php
/**
 * Rating data model class file.
 * @author: Raysmond
 */

class Rating extends RModel
{

    public $id, $entityType, $entityId, $valueType, $value = 0, $tag, $userId = 0, $host, $timestamp;

    private $_user = null;

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


    public function save()
    {
        if (!isset($this->timestamp) || $this->timestamp === '') {
            $this->timestamp = date('Y-m-d H:i:s');
        }
        return parent::save();
    }

    /**
     * Get user who rated the entity
     * @return $this|null User object for registered users or null for anonymous users
     */
    public function getUser()
    {
        if ($this->userId != 0 && $this->_user === null) {
            $this->_user = User::get($this->userId);
        }
        return $this->_user;
    }

}