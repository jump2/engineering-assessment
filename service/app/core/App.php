<?php
namespace app\core;

use app\core\db\Elastic;

class App
{
    public static function handle($request, $response)
    {
        $uri = explode('/', $request->server['request_uri']);
        array_shift($uri);
        $controller = $uri[0] ?? 'index';
        $action = $uri[1] ?? 'index';

        $className = '\\app\\controller\\' . ucwords($controller) . 'Controller';
        if(method_exists($className, $action)) {
            $return = (new $className($request))->$action();
        } else {
            $response->header('content-type', 'application/json; charset=utf-8');
            $response->status(400);
            $return = static::return(400, [], 'Page Not Found');
        }

        if (is_array($return)) {
            $response->header('content-type', 'application/json; charset=utf-8');
            $response->end(json_encode($return, true));
        } else {
            $response->end($return);
        }
    }

    public static function elastic()
    {
        return Elastic::getInstance();
    }

    public static function returnSuccess($data = [], $msg = 'ok')
    {
        return static::return(0, $data, $msg);
    }

    public static function return($code, $data, $msg)
    {
        return [
            'error_code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];
    }
}