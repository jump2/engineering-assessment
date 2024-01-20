<?php
require_once __DIR__.'/vendor/autoload.php';

use Swoole\Http\Request;
use Swoole\Http\Response;
use app\core\App;

$http = new Swoole\Http\Server("0.0.0.0", 80);
$http->on('request', function (Request $request, Response $response) {
    App::handle($request, $response);
});
$http->start();