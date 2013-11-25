<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-11-25
 * Time: PM7:59
 */

interface RICacheHelper {
    public function get( $cacheId, $factor, $time );
    public function set( $cacheId, $factor, $content );

} 