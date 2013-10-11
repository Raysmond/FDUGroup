<?php
// Raysmond

require_once("arch.php");

class Tag extends Data{
    public $entity_type;
    public $tagId,$tagName,$entityTypeId,$entityId;

    public function __construct() {
        $options =array(
            "key" => "tagId",
            "table" => "tag",
            "columns" => array(
                "tagId" => "tag_id",
                "tagName" =>"tag_name",
                "entityTypeId" => "entity_type",
                "entityId" => "entity_id",
            )
        );
        parent::init($options);
    }

    public function load($id = null) {
        parent::load($id);
        $this->entity_type = new EntityType();
        $this->entity_type->type_id = $id;
    }

}