<?php

namespace Framework\Database\Commands;

use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Facades\Path;

class MakeModelCommand extends BaseCommand implements CommandInterface
{
    private string $modelPath = '';

    public function __construct()
    {
        $this->modelPath = Path::join(__DIR__, '..', '..', '..', 'app', 'Models');
    }

    public function execute(array $args): int
    {
        $modelName = $this->input('Model name (e.g. Product):');
        $filename = $modelName . '.php';
        $path = Path::join($this->modelPath, $filename);

        file_put_contents(
            $path,
            '<?php' . PHP_EOL . PHP_EOL .
            'namespace App\Models;' . PHP_EOL . PHP_EOL .
            'use Framework\Database\Database;' . PHP_EOL . PHP_EOL .
            'class ' . $modelName . ' extends \Framework\Database\BaseModel' . PHP_EOL .
            '{' . PHP_EOL .
            '    protected static function new(array $data = []): self' . PHP_EOL .
            '    {' . PHP_EOL .
            '        return new self($data);' . PHP_EOL .
            '    }' . PHP_EOL . PHP_EOL .
            '    public function save(): self' . PHP_EOL .
            '    {' . PHP_EOL .
            '        if ($this->getId() === null) {' . PHP_EOL .
            '            Database::prepared(\'INSERT INTO \' . $this->getTableName() . \' (...\');' . PHP_EOL .
            '        } else {' . PHP_EOL .
            '            $this->checkAllowEdit();' . PHP_EOL .
            '            Database::prepared(\'UPDATE \' . $this->getTableName() . \' SET ...\');' . PHP_EOL .
            '        }' . PHP_EOL . PHP_EOL .
            '        return $this;' . PHP_EOL .
            '    }' . PHP_EOL .
            '}' . PHP_EOL
        );

        printLn('Created model "' . $filename . '"');

        return 0;
    }

    public function getName(): string
    {
        return 'make:model';
    }

    public function getDescription(): string
    {
        return 'Create a new model';
    }
}
