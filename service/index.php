<?php
require_once __DIR__.'/vendor/autoload.php';

use Swoole\Http\Request;
use Swoole\Http\Response;
use app\controller\TestController;
use Elastic\Elasticsearch\ClientBuilder;
use app\core\App;

$client = ClientBuilder::create()->setHosts(['es:9200'])->build();

$http = new Swoole\Http\Server("0.0.0.0", 80);
$http->on('request', function (Request $request, Response $response) use ($client) {
    App::handle($request, $response);
});
$http->start();