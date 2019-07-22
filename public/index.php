<?php
define('FIREWORM_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../src/Application.php';
dd($app);
$kernel = $app->make(FIREWORM\Contracts\Http\Kernel::class);

$response = $kernel->handle($request = Illuminate\Http\Request::capture());
$response->send();

$kernel->terminate($request, $response);