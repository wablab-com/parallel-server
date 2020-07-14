<?php


namespace WabLab\ParallelServer;


use WabLab\ParallelServer\Contracts\Logger;
use Codedungeon\PHPCliColors\Color;

class ConsoleLogger implements Logger
{

    public function debug($message)
    {
        $date = date('Y-m-d H:i:s');
        echo Color::LIGHT_CYAN, "[$date][DEBUG] {$message}", Color::RESET, PHP_EOL;
    }

    public function info($message)
    {
        $date = date('Y-m-d H:i:s');
        echo Color::RESET, "[$date][INFO] {$message}", PHP_EOL;
    }

    public function warning($message)
    {
        $date = date('Y-m-d H:i:s');
        echo Color::LIGHT_YELLOW, "[$date][WARNING] {$message}", Color::RESET, PHP_EOL;
    }

    public function error($message)
    {
        $date = date('Y-m-d H:i:s');
        echo Color::LIGHT_RED, "[$date][ERROR] {$message}", Color::RESET, PHP_EOL;
    }

    public function success($message)
    {
        $date = date('Y-m-d H:i:s');
        echo Color::LIGHT_GREEN, "[$date][SUCCESS] {$message}", Color::RESET, PHP_EOL;
    }
}