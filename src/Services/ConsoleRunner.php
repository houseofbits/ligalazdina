<?php

namespace LigaLazdinaPortfolio\Services;

use LigaLazdinaPortfolio\Helpers\Console;

class ConsoleRunner
{
    public function run(array $params): void
    {
        if (!isset($params[1])) {
            Console::printLn('No args', 'e');
            return;
        }

        $method = strtolower($params[1]);
        $method = str_replace('-', '', ucwords($method, '-'));

        if (!method_exists($this, $method)) {
            Console::printLn('Command not recognized', 'e');
            return;
        }

        $params = array_slice($params, 2);

        $this->$method(...$params);
    }
}