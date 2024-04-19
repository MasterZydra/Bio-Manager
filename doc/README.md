# Documentation

[Deep dive into the framework](Framework.md)

**Application code**  
- [Configuration](#Configuration)
- [Routes](#routes)
- [Controllers](#controllers)
- [Views](#views)
- [Localization](#localization)
- [Models](#models)
- [BaseModel](#basemodel)
- [Query builder](#query-builder)
- [Migrations](#migrations)
- [Seeders](#seeders)
- [CLI commands](#cli-commands)
- [Tests](#tests)

# Application code
The application specific code is located in the directories [`app`](../app), [`resources`](../resources/) and [`tests`](../tests/).

## Configuration
The configuration of the application is done in the file`.env`.
You can use the file [`.env.example`](../.env.example) as template.

If you run the application as a container, you can also set them as environment variables (e.g. `--env DB_PASSWORD=myPassword`).

```toml
APP_URL="http://localhost" # URL the application is listening on
APP_ENV="dev" # 'dev' or 'prod'

APP_LANG="en" # Default/fallback language

DB_CONNECTION="mariadb"
DB_HOST="127.0.0.1"
DB_PORT=3306
DB_DATABASE="bioman"
DB_USERNAME="user"
DB_PASSWORD="secret"

# Or SQLite
DB_CONNECTION="sqlite"
DB_FILE="path/bioman.db"
```

-------------------------------------------------------------

## Routes
The available routes are configured in the [`app/routes.php`](../app/routes.php) file.

There are multiple ways for configuration:

### As function
```PHP
/** Render the view 'about' (/resources/Views/about.php) */
Router::addFn('about', fn() => view('about'));
```

### As controller
> **Hint:** You can use the bioman CLI to create a new empty controller: `make:controller`

The controller class must implement the [`Framework\Routing\ControllerInterface`](../framework/Routing/ControllerInterface.php).
```PHP
/** The function 'execute()' is called in the AboutController class */
Router::addController('about', new AboutController());
```

### As resource
> **Hint:** You can use the bioman CLI to create a new empty controller: `make:controller`

The controller must implement the [`Framework\Routing\ModelControllerInterface`](../framework/Routing/ModelControllerInterface.php).

```PHP
/** Routes: user, user/show, user/create, user/store, etc. */
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

A model can be used as a wrapper for a database table or to encapsulte application logic.
If you extend your class from the [`BaseModel`](../framework/Database/BaseModel.php), you get access to helper functions.
These already implement deletion, finding multiple or single instances, etc.

Your table scheme should use the column `id` as primary key in order to use the BaseModel.

See [BaseModel](#basemodel)

-------------------------------------------------------------

## BaseModel
The [`BaseModel`](../framework/Database/BaseModel.php) provides logic to simplify the usage of a model that is stored in the database.

The BaseModel assumes that the identifier column is named `id`.

### Functions
```PHP
/** Get an empty query builder */
public static function getQueryBuilder(): WhereQueryBuilder;

/** Get an array of models */
public static function all(WhereQueryBuilder $query = null): array;

/** Get the first model that matches the given query */
public static function find(WhereQueryBuilder $query): self;

/** Get the model with the given id */
public static function findById(int $id): self;

/** Delete the model with the given id */
public static function delete(int $id): void;

/** Set the given fields from the the eponymous HTTP parameters */
public function setFromHttpParams(array $fields): self;

/** Set the given field from the the eponymous HTTP parameter */
public function setFromHttpParam(string $field, string $param = null): self;
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

### Allow functions
The allow functions are optional functions that can be added to a model for doing checks before the edit or delete operation.
Possible checks could be permission checks to ensure that the current user is allowed to delete that entity. Another useful check is a dependency checks. Here you can check if a invoice is aleady paid and prevent the edit and delete operation in that case.

**Signatures**
```PHP
/* Gets executed if the `save()` function is called */
public function allowEdit(): bool;

/** Gets executed if the `delete($id)` function is called */
public function allowDelete(): bool;
```

**Examples**
```PHP
public function allowEdit(): bool
{
    return match (true) {
        $this->getIsPaid() => false,
        // More checks...
        default => true,
    };
}

public function allowDelete(): bool
{
    if ($this->getIsPaid()) {
        return false;
    }

    // More checks...

    return true;
}
```

### Default sort order
You can use the [(Where)QueryBuilder](#query-builder) to set the sort order when calling `Model::all(...)`. This way you must set that order possibly on multiple locations in your source code.

You can use the static property `orderBy` to set a default order.
It will be used if no other sort order is passed via `QueryBuilder->orderBy(...)`.

**Example**
```PHP
class Plot extends BaseModel
{
    public static array $orderBy = ['isLocked' => 'asc', 'nr' => 'asc'];
```

-------------------------------------------------------------

## Query builder
The query builder can be used to create SQL select statements.
By default all columns are selected (`*`).
If you want to some specific columns, you can add them with the function `select`.

**Available functions on query builder**
```PHP
/** Add a column to the select `SELECT` part */
public function select(string $column): self;

/** Add a condition to the `WHERE` part */
public function where(ColType $type, string $column, Condition $condition, mixed $value, WhereCombine $combine = WhereCombine::And): self;

/** Add a column to the `ORDER BY` part */
public function orderBy(string $column, SortOrder $sortOrder = SortOrder::Asc): self;
```

If you use the query builder for a model, you can use the return value from the function `getTableName` as constructor parameter.

**Example**
```bash
$dataSet = Database::executeBuilder(
    QueryBuilder::new(self::getTableName())
        ->select('MAX(nr) + 1 AS nextId')
        ->where(ColType::Int, 'year', Condition::Equal, $year)
);
```

### WhereQueryBuilder
The WhereQueryBuilder is used as (optional) parameter for the base model functions `all` and `find`. It only implements the functions `where` and `orderBy`.

The creation of the WhereQueryBuilder is simplified with the function `getQueryBuilder` provided by the base model.

**Example**
```PHP
self::find(self::getQueryBuilder()->where(ColType::Str, 'username', Condition::Equal, $username));
```

-------------------------------------------------------------

## Migrations
> **Hint:** You can use the bioman CLI to create a new migration: `make:migration`

The migration system has the purpose to get rid of manual changes on the database schema. A migration consists of one or more SQL statement that e.g. creates, deletes or alters a table.

A migration is only executed once. To execute every newly added migration, run the `migrate` command in the bioman CLI.

**Example**
```PHP
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        // code
        ...
```

### CreateTableBlueprint
Each DBSM has its own specific syntax.
The blueprint class `CreateTableBlueprint` can be used for the creation of a new table in MariaDB and SQLite.
Each supported database driver implements the [`CreateTableBlueprintInterface`](../framework/Database/Interface/CreateTableBlueprintInterface.php).

**Example**
```PHP
use Framework\Database\CreateTableBlueprint;
use Framework\Database\Database;
use Framework\Database\Migration\Migration;

return new class extends Migration
{
    public function run(): void
    {
        Database::executeBlueprint((new CreateTableBlueprint('users'))
            ->id()
            ->string('name', 100)
            ->date('lastLogin')
            ->int('languageId', foreignKey: ['languages' => 'id'])
            ->timestamps()
        );
    }
};
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
use Framework\Database\Seeder\Seeder;
use Framework\Database\Seeder\SeederInterface;

class UserSeeder extends Seeder implements SeederInterface
{
    public function run(): void
    {
        // code
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

## Tests
> **Hint:** You can use the bioman CLI to create a new test case: `make:testcase`

You can create unit tests to ensure that the application behaves like expected, even after changing some functions behaviour.

To execute the test suite run the `test:run` command in the bioman CLI.

**Example**  
This test case checks if the `boolToInt` convertion function always returns the value `1` for the input value `true`.

```PHP
use Framework\Facades\Convert;
use Framework\Test\TestCase;

class TestConvert extends TestCase
{
    public function testBoolToInt(): void
    {
        $this->assertEquals(1, Convert::boolToInt(true));
        $this->assertEquals(0, Convert::boolToInt(false));
    }
}
```

-------------------------------------------------------------
