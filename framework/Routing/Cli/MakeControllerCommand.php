<?php

namespace Framework\Routing\Cli;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Facades\Path;

class MakeControllerCommand extends BaseCommand implements CommandInterface
{
    private string $controllersPath = '';

    public function __construct()
    {
        $this->controllersPath = Path::join(__DIR__, '..', '..', '..', 'app', 'Http', 'Controllers');
    }

    public function execute(array $args): int
    {
        $controllerName = $this->input('Controller name (e.g. Product):');
        $filename = $controllerName . 'Controller.php';
        $path = Path::join($this->controllersPath, $filename);

        file_put_contents(
            $path,
            '<?php' . PHP_EOL . PHP_EOL .
            'namespace App\Http\Controllers;' . PHP_EOL . PHP_EOL .
            'use Framework\Routing\BaseController;' . PHP_EOL .
            'use Framework\Routing\ModelControllerInterface;' . PHP_EOL . PHP_EOL .
            'class ' . $controllerName . 'Controller extends BaseController implements ModelControllerInterface' . PHP_EOL .
            '{' . PHP_EOL .
            '    /**' . PHP_EOL .
            '     * Show list of all models' . PHP_EOL .
            '     * Route: <base route>' . PHP_EOL .
            '     */' . PHP_EOL .
            '    public function index(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '       // Code' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    /**' . PHP_EOL .
            '     * Show the details of one model' . PHP_EOL .
            '     * Route: <base route>/show' . PHP_EOL .
            '     */' . PHP_EOL .
            '    public function show(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        // Code' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    /**' . PHP_EOL .
            '     * Show form to create one model' . PHP_EOL .
            '     * Route: <base route>/create' . PHP_EOL .
            '     */' . PHP_EOL .
            '    public function create(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        // Code' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    /**' . PHP_EOL .
            '     * Create a new model with the informations from the create form' . PHP_EOL .
            '     * Route: <base route>/store' . PHP_EOL .
            '     */' . PHP_EOL .
            '    public function store(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        // Code' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    /**' . PHP_EOL .
            '     * Show form to edit one model' . PHP_EOL .
            '     * Route: <base route>/edit' . PHP_EOL .
            '     */' . PHP_EOL .
            '    public function edit(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        // Code' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    /**' . PHP_EOL .
            '     * Update one model with the informations from the edit form' . PHP_EOL .
            '     * Route: <base route>/update' . PHP_EOL .
            '     */' . PHP_EOL .
            '    public function update(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        // Code' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    /**' . PHP_EOL .
            '     * Delete one model' . PHP_EOL .
            '     * Route: <base route>/destroy' . PHP_EOL .
            '     */' . PHP_EOL .
            '    public function destroy(): void' . PHP_EOL .
            '    {' . PHP_EOL .
            '        // Code' . PHP_EOL .
            '    }' . PHP_EOL .
            '}' . PHP_EOL
        );

        printLn('Created controller "' . $filename . '"');

        return 0;
    }

    public function getName(): string
    {
        return 'make:controller';
    }

    public function getDescription(): string
    {
        return 'Create a new controller';
    }
}