<?php
/**
 * Created by PhpStorm.
 * User: Raysmond
 * Date: 13-11-25
 * Time: PM8:04
 */

class RFileCacheHelper implements RICacheHelper
{

    private $length = 3000;
    public $cacheDir = null;
    public $cacheTime = 3600;
    public $cachePrefix = 'cache_';

    public function __construct($_args = array())
    {
        if ($_args != null) {
            if (isset($_args['cache_dir']))
                $this->cacheDir = Rays::app()->getBaseDir().'/..'.$_args['cache_dir'].'/';
            if (isset($_args['length']))
                $this->length = $_args['length'];
            if(isset($_args['cacheTime']))
                $this->cacheTime = $_args['cacheTime'];
            if(isset($_args['cachePrefix']))
                $this->cachePrefix = $_args['cachePrefix'];
        }
    }

    private function getCacheFile($cacheId, $name)
    {
        $path = $this->cacheDir . str_replace('.', '/', $cacheId);
        return $path . '/' . ($name !== null ? $this->cachePrefix . $name . '.html' : $this->cachePrefix.'untitled.html');
    }

    public function get($cacheId, $name, $expireTime=null)
    {
        $cachedFile = $this->getCacheFile($cacheId, $name);
        $time = $this->cacheTime;
        if($expireTime!=null){
            $time = $expireTime;
        }

        if (!file_exists($cachedFile)) return FALSE;
        if ($time < 0) return file_get_contents($cachedFile);
        if (filemtime($cachedFile) + $time < time()) return FALSE;
        return file_get_contents($cachedFile);
    }

    public function set($cacheId, $name = null, $_content)
    {
        $cachedFile = $this->getCacheFile($cacheId, $name);

        $path = dirname($cachedFile);
        //check and make the $path dir
        if (!file_exists($path)) {
            $dir = dirname($path);
            $names = array();
            do {
                if (file_exists($dir)) break;
                $names[] = basename($dir);
                $dir = dirname($dir);
            } while (true);

            for ($i = count($names) - 1; $i >= 0; $i--) {
                $dir = $dir . '/' . $names[$i];
                //mkdir($_dir, 0x777);
                mkdir($dir);
            }
            //mkdir($path, 0x777);
            mkdir($path);
        }

        return file_put_contents($cachedFile, $_content);
    }
} 