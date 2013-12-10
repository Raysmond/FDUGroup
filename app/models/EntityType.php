<?php
/**
 * EntityType model
 *
 * @author: Raysmond
 */

class EntityType extends RModel{
    public $typeId,$typeName;

    public static $table = "entity_type";
    public static $primary_key = "typeId";

    public static $mapping = array(
                    "typeId" => "typ_id",
                    "typeName" =>"typ_name",
                    );
}


