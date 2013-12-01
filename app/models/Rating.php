<?php
/**
 * Rating data model class file.
 * @author: Raysmond
 */

class Rating extends Data
{

    public $id, $entityType, $entityId, $valueType, $value = 0, $tag, $userId = 0, $host, $timestamp;

    private $_user = null;

    public function __construct()
    {
        $options = array(
            "key" => "id",
            "table" => "rating",
            "columns" => array(
                "id" => "rating_id",
                'entityType' => 'entity_type',
                "entityId" => "entity_id",
                "valueType" => "value_type",
                "value" => "value",
                "tag" => "tag",
                "userId" => "u_id",
                "host" => "host",
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

    /**
     * Get user who rated the entity
     * @return $this|null User object for registered users or null for anonymous users
     */
    public function getUser()
    {
        if ($this->userId != 0 && $this->_user === null) {
            $this->_user = new User();
            $this->_user->id = $this->userId;
            $this->_user = $this->_user->load();
        }
        return $this->_user;
    }

}