<?php
/**
 * Index file.
 * @author: Raysmond
 */

$raysFramework = dirname(__FILE__).'/arch/Rays.php';
$config = dirname(__FILE__).'/arch/Config.php';

require_once($raysFramework);

Rays::createApplication($config)->run();
