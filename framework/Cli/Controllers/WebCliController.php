<?php

namespace Framework\Cli\Controllers;

use Framework\Cli\Cli;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class WebCliController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        if ($this->getRequestMethod() === 'GET') {
            view('framework.cli.webcli');
            return;
        }

        if ($this->getRequestMethod() === 'POST') {
            $cli = new Cli();
            $cli->runWebCli($this->getParam('command', ''));
            return;
        }
    }
}