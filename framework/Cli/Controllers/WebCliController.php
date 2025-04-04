<?php

declare(strict_types = 1);

namespace Framework\Cli\Controllers;

use Framework\Authentication\Auth;
use Framework\Cli\Cli;
use Framework\Facades\Http;
use Framework\Routing\BaseController;
use Framework\Routing\ControllerInterface;

class WebCliController extends BaseController implements ControllerInterface
{
    public function execute(): void
    {
        Auth::checkRole('Developer');

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