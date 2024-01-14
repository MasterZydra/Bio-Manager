# Documentation

[Deep dive into the framework](Framework.md)

**Application code**  
- [Routes](#routes)
- [Controllers](#controllers)
- [Views](#views)
- [Localization](#localization)
- [Models](#models)
- [Migrations](#migrations)
- [Seeders](#seeders)
- [CLI commands](#cli-commands)

# Application code
The application specific code is located in the directories [`app`](../app), [`resources`](../resources/) and [`tests`](../tests/).

## Routes
The available routes are configured in the [`app/routes.php`](../app/routes.php) file.

There are multiple ways for configuration:

### As function
```PHP
# Render the view 'about' (/resources/Views/about.php)
Router::addFn('about', fn() => view('about'));
```

### As controller
> **Hint:** You can use the bioman CLI to create a new empty controller: `make:controller`

The controller class must implement the [`Framework\Routing\ControllerInterface`](../framework/Routing/ControllerInterface.php).
```PHP
# The function 'execute()' is called in the AboutController class
Router::addController('about', new AboutController());
```

### As resource
> **Hint:** You can use the bioman CLI to create a new empty controller: `make:controller`

The controller must implement the [`Framework\Routing\ModelControllerInterface`](../framework/Routing/ModelControllerInterface.php).

```PHP
# Routes: user, user/show, user/create, user/store, etc.
Router::addResource('user', new UserController());
```

If the corresponding function exists in the controller class, the associated route gets registered:

| Function | Route | Methode | Description |
| -------- | ----- | ------- | ----------- |
| `public function index(): void` | `<base route>` | `GET` | Show list of all models |
| `public function show(): void` | `<base route>/show?id=...` | `GET` | Show the details of one model |
| `public function create(): void` | `<base route>/create` | `GET` | Show form to create one model |
| `public function store(): void` | `<base route>/store` | `POST` | Create a new model with the informations from the create form |
| `public function edit(): void` | `<base route>/edit?id=...` | `GET` | Show form to edit one model |
| `public function update(): void` | `<base route>/update` | `POST` | Update one model with the informations from the edit form |
| `public function destroy(): void` | `<base route>/destroy` | `POST` | Delete one model |

-------------------------------------------------------------

## Controllers
> **Hint:** You can use the bioman CLI to create a new empty controller: `make:controller`

A custom controller must implement the [`ControllerInterface`](../framework/Routing/ControllerInterface.php) or the [`ModelControllerInterface`](../framework/Routing/ModelControllerInterface.php) depending on the kind of route registration used. The [`BaseController`](../framework/Routing/BaseController.php) can be used as base class to get access to helper functions.
The default directory is [`app/Http/Controllers`](../app/Http/Controllers/).

**Example**
```PHP
use Framework\Routing\BaseController;

class AboutController extends BaseController
```

-------------------------------------------------------------

## Views
The views must be PHP files. The default directory is [`resources/Views`](../resources/Views/). The location for components is [`resources/Views/Components`](../resources/Views/Components/).  
If a view is placed inside a subdirectory the dot is used as seprator.  
For example: `resources/Views/user/index.php` => `user.index`

A view can be rendered with the global available function `view(string $name, ...)`. For components the global available function `component(string $name, ...)` can be used.

-------------------------------------------------------------

## Localization

The localization system provides the global available translation function `__(string $labelname)`.
The labels are stored in PHP arrays (`<language code>.php` e.g. `de.php`) in [`resources/Lang`](../resources/Lang/).

**Example `en.php`**
```PHP
<?php

return [
    'AddProduct' => 'Produkt hinzufügen',
    ...
    'WelcomeToMemberArea' => 'Willkommen im Mitgliederbereich',
];
```

-------------------------------------------------------------

## Models
> **Hint:** You can use the bioman CLI to create a new empty command: `make:model`

### BaseModel functions
It is recommended to use the BaseModel and name the identifier column `id`. This ways the following functions can be used for every model:

```PHP
# Get an array of models
public static function all(): array;

# Get the model with the given id
public static function find(int $id): self;

# Delete the model with the given id
public static function delete(int $id): void;
```

**Example model**
```PHP
use Framework\Database\BaseModel;
use Framework\Database\Database;

class Role extends BaseModel
```

### Table name
A model class is a wrapper for a database table. The name of the table must be the plural of the class name so that the model can resolve the table name.

Examples:  
Model: `User` => Table: `users`  
Model: `Product` => Table: `products`

### Table fields
To access the fields of a model the magic get- and set-functions can be used: `<get/set><field name>`

Examples:  
Field: `name` => Getter: `getName(): mixed`, Setter: `setName(mixed $value): self`  
Field: `isLocked` => Getter: `getIsLocked(): mixed`, Setter: `setIsLocked(mixed $value): self`

> **Recommendation:** Add explicit functions for type safety. You can use the helper getter and setter like `getDataString`, `getDataIntOrNull`, `setDataFloat`, `setDataBoolOrNull`, etc.

**Example explicit getter and setter**
```PHP
private const USERNAME = 'username';

/* Getter & Setter */

public function setUsername(string $value): self
{
    return $this->setDataString(self::USERNAME, $value);
}

public function getPassword(): ?string
{
    return $this->getDataStringOrNull(self::PASSWORD);
}
```

-------------------------------------------------------------

## Migrations
> **Hint:** You can use the bioman CLI to create a new migration: `make:migration`

The migration system has the purpose to get rid of manual changes on the database schema. A migration consists of one or more SQL statement that e.g. creates, deletes or alters a table.

A migration is only executed once. To execute every newly added migration, run the `migrate` command in the bioman CLI.

**Example**
```PHP
use Framework\Database\Database;
use Framework\Database\Migration;

return new class extends Migration
{
    public function run(): void
    {
        # code
        ...
```

-------------------------------------------------------------

## Seeders
> **Hint:** You can use the bioman CLI to create a new empty seeder: `make:seeder`

A seeder can be used to fill a table with random or fixed values.
The seeder class can be called in [`DatabaseSeeder.php`](../resources/Database/Seeders/DatabaseSeeder.php).
The default seeders in [`DatabaseSeeder.php`](../resources/Database/Seeders/DatabaseSeeder.php) are executed when executing the bioman CLI command `db:seed`.

Another way to use a seeder is to call it inside a migration, for example after the user table creation to insert a default user.

**Example**
```PHP
use Framework\Database\Database;
use Framework\Database\Seeder;
use Framework\Database\SeederInterface;

class UserSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        # code
        ...
```

-------------------------------------------------------------

## CLI commands
> **Hint:** You can use the bioman CLI to create a new empty command: `make:command`

The [`bioman`](../bioman) CLI can be extended with custom commands.
The registration of a command must be done in [`app/registerCli.php`](../app/registerCli.php).  
For example: `Cli::registerCommand(new TestRun());`

The command class must implement the [`CommandInterface`](../framework/Cli/CommandInterface.php).
The [`BaseCommand`](../framework/Cli/BaseCommand.php) class can be used as base class to get access to helper functions.

**Example**
```PHP
use Framework\Cli\BaseCommand;
use Framework\Cli\CommandInterface;
use Framework\Test\TestRunner;

class TestRun extends BaseCommand implements CommandInterface
```

-------------------------------------------------------------
