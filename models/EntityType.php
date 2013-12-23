<?php
/**
 * EntityType model
 *
 * @author: Raysmond
 */

class EntityType extends RModel
{
    public $typeId, $typeName;

    public static $table = "entity_type";
    public static $primary_key = "typeId";

    public static $mapping = array(
        "typeId" => "typ_id",
        "typeName" => "typ_name",
    );

    private static $id_or_name_mapping = array();

    public static function getTypeId($typeName)
    {
        if (!isset(self::$id_or_name_mapping[$typeName])) {
            $type = EntityType::find("typeName", $typeName)->first();
            self::$id_or_name_mapping[$typeName] = $type != null ? $type->typeId : null;
        }
        return self::$id_or_name_mapping[$typeName];
    }

    public static function getTypeName($typeId)
    {
        if (!isset(self::$id_or_name_mapping[$typeId])) {
            $type = EntityType::get($typeId);
            self::$id_or_name_mapping["_id_".$typeId] = $type != null ? $type->typeName : null;
        }
        return self::$id_or_name_mapping["_id_".$typeId];
    }
}


