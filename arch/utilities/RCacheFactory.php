<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-11-25
 * Time: PM8:07
 */

class RCacheFactory {

    public static function create( $_class, $_args = NULL ) {

        return new $_class($_args);

    }
}