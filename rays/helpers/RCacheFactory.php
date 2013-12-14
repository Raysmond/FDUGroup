<?php
/**
 * RCacheFactory helper class
 *
 * @author: Raysmond
 */

class RCacheFactory {

    public static function create( $_class, $_args = NULL ) {

        return new $_class($_args);

    }
}