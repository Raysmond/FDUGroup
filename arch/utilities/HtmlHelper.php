<?php
/**
 * HtmlHelper class file.
 * @author: Raysmond
 */

class HtmlHelper {

    public static function encode($content){
        return htmlspecialchars($content,ENT_QUOTES,Rays::app()->charset);
    }

    public static function decode($content){
        return htmlspecialchars_decode($content,ENT_QUOTES);
    }
}