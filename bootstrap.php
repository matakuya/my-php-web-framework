<?php
/**
 * Created by PhpStorm.
 * User: mikake
 * Date: 18/02/17
 * Time: 2:31
 */

require 'core/ClassLoader.php';

$loader = new ClassLoader();
$loader->registerDir(dirname(__FILE__) . '/core');
$loader->registerDir(dirname(__FILE__) . '/models');
$loader->register();