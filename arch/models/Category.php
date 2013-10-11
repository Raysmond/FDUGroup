<?php
// Raysmond

require_once("./arch.php");

class Category extends Tree
{
    public $id, $pid, $name;

    public function __construct()
    {
        $option = array(
            "key" => "id",
            "pkey" => "pid",
            "table" => "category",
            "columns" => array(
                "id" => "cat_id",
                "name" => "cat_name",
                "pid" => "cat_pid"
            )
        );

        parent::init($option);
    }

}