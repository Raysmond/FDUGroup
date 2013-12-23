<?php
/**
 * Base model for tree-like structures
 * @author Xiangyan Sun
 */

class Tree extends RModel
{
    public function parent()
    {
        $model = get_called_class();
        return $model::get($model::$parent_key);
    }

    public function children()
    {
        $model = get_called_class();
        return $model::find($model::$parent_key, $this->{$model::$primary_key})->all();
    }
}