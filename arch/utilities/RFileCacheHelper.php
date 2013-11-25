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


    public function __construct($_args)
    {
        if ($_args != null) {
            if (isset($_args['cache_dir']))
                $this->cacheDir = $_args['cache_dir'];
            if (isset($_args['length']))
                $this->length = $_args['length'];
        }
    }

    private function getCacheFile($cacheId, $name)
    {
        $path = $this->cacheDir . str_replace('.', '/', $cacheId);
        return $path . '/' . ($name !== null ? $name . '.cache.html' : 'default.cache.html');
    }

    public function get($cacheId, $name, $expireTime)
    {
        $cachedFile = $this->getCacheFile($cacheId, $name);

        if (!file_exists($cachedFile)) return FALSE;
        if ($expireTime < 0) return file_get_contents($cachedFile);
        if (filemtime($cachedFile) + $expireTime < time()) return FALSE;
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