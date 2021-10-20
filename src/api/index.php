<?php
define('ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT . 'App' . DIRECTORY_SEPARATOR);
define('DIR_SETTING', APP_DIR . 'settings'. DIRECTORY_SEPARATOR);

require_once(ROOT . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

require_once(DIR_SETTING . 'env.php');
require_once(ROOT . 'App' . DIRECTORY_SEPARATOR . 'bootstrap.php'); //start App