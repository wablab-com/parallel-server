<?php


namespace WabLab\ParallelServer\Contracts;


interface Logger
{
    public function debug($message);

    public function info($message);

    public function warning($message);

    public function error($message);

    public function success($message);

}