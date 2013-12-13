<?php
/**
 * Index file.
 * @author: Raysmond
 */

$rays = dirname(__FILE__).'/rays/Rays.php';
$config = dirname(__FILE__).'/app/Config.php';

require_once($rays);

Rays::newApp($config)->run();
