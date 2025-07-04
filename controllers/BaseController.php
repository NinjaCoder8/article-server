<?php

require_once __DIR__ . "/../connection/connection.php";
require_once __DIR__ . "/../services/ResponseService.php";
require_once __DIR__ . "/../services/ArticleService.php";



class BaseController
{
    protected $mysqli;

    public function __construct()
    {
        global $mysqli;
        $this->mysqli = $mysqli;
    }

    protected function success($data)
    {
        echo ResponseService::success_response($data);
    }

    protected function error($message)
    {
        echo ResponseService::error_response($message);
    }
}
