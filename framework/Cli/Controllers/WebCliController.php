<?php

namespace Framework\Cli\Controllers;

use Framework\Cli\Cli;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class WebCliController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        if (Http::requestMethod() === 'GET')
        {
            view('framework.cli.webcli');
            return;
        }

        if (Http::requestMethod() === 'POST')
        {
            Cli::runWebCli(Http::param('command', ''));
            return;
        }
    }
}