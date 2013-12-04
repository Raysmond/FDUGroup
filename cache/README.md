Dynamic content file cache
==========
**Code example**
<pre>
$cache = RCacheFactory::create('RFileCacheHelper', Rays::app()->getCacheConfig());
if ( ($cacheContent = $cache->get("users", "new_users", 60)) != FALSE ) {
    echo $cacheContent;
}
else{
    $cacheContent = $this->module("new_users",array('id'=>'new_users','name'=>"New Users"),true);
    $cache->set("users", "new_users", $cacheContent);
    echo $cacheContent;
    unset($cacheContent);
}
</pre>