<?php
namespace app\controller;


class BaseController
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
}