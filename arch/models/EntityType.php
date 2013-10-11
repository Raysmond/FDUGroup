<?php
/**
 * Class EntityType
 * @author: Raysmond
 */

class EntityType extends Data{
    public $typeId,$typeName;

    public function __construct() {
        $options =array(
            "key" => "typeId",
            "table" => "entity_type",
            "columns" => array(
                "typeId" => "typ_id",
                "typeName" =>"typ_name",
            )
        );
        parent::init($options);
    }

    public function load($id = null) {
        parent::load($id);
    }
}


