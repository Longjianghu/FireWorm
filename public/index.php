<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 2019-02-12
 * Time: 15:24
 */

define('ROOT_PATH', dirname(__DIR__));
define('CORE_PATH', ROOT_PATH.'/core');
define('APP_PATH', ROOT_PATH.'/app');
define('RUN_PATH', ROOT_PATH.'/runtime');
define('DEBUE', true);

ini_set('date.timezone', 'Asia/Shanghai');
ini_set('display_errors', ( ! empty(DEBUE)) ? 'On' : 'Off');

include_once CORE_PATH.'/common/function.php';
include_once CORE_PATH.'/bootstrap.php';

spl_autoload_register('\core\bootstrap::loadClass');

\core\bootstrap::run();