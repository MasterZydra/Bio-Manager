# Documentation

[Deep dive into the application code](README.md)

**Framework**
- [Authentication and Authorization](#authentication-and-authorization)
- [Messages](#messages)
- [Migrations](#migrations)
- [Tests](#tests)
- [Localization](#localization)

# Framework
The framework code is located in the directories [`framework`](../framework/) and [`bootstrap`](../bootstrap/).

## Authentication and Authorization
The class [`framework/Authentication/Auth`](../framework/Authentication/Auth.php) provides functions for authentication and authorization.

The session is used to store the userId after a successful login.
With the function `Auth::id()` the id or null is returned.
Based on it the function `Auth::isLoggedIn()` does this check.

A role based model is used for authorization.
The user can have zero up to multiple roles.
Each role is stored in the table `roles` and has a name.
The assignment is stored as combination of `userId` and `roleId` in the table `userRoles`.
The function `Auth::hasRole(string $role)` can be used to check if the current user has a given role assigned.
It is also possible to check if a given user has a given role assigned with the function `userHasRole(int $userId, string $role)`.

The class [`Auth`](../framework/Authentication/Auth.php) also contains functions for the password hashing and validation that are used in the [user login controller](../app/Http/Controllers/User/LoginController.php) and for setting and updating the password.

-------------------------------------------------------------

## Messages
The class [`Message`](../framework/Message/Message.php) provides the function `setMessage(string $message, Type $type)` that can be used to set messages that will be shown on the next page load of the user.
This way errors, warnings, information messages, etc. can be passed e.g. from an controller to the frontend.

The session is used to store the messages. On each page load the [`header`](../resources/Views/Components/layout/header.php) uses the class [`Message`](../framework/Message/Message.php) to pop all messages from the session and render them into HTML code.

-------------------------------------------------------------

## Migrations
The [migration runner](../framework/Database/MigrationRunner.php) checks the directories
[`resources/Database/Migrations`](../resources/Database/Migrations/) and[`framework/Database/Migrations`](../framework/Database/Migrations/) for migration files.
The [migration runner](../framework/Database/MigrationRunner.php) checks if the migration was already executed by searching the table `migrations` for an entry with the migrations name. After executing a migration, its name is stored in the table `migrations` to keep track of already exeucted migrations.

-------------------------------------------------------------

## Tests
The [test runner](../framework/Test/TestRunner.php) checks the directories [`tests`](../tests/) and [`framework/tests`](../framework/tests/) for test files.
The unit tests must be located in the subdirectory `Unit` and the filename must start with `Test` and end with `.php`.
The base class [`TestCase`](../framework/Test/TestCase.php) provides assert functions (e.g. `assertTrue(bool $assertion)` or `assertEquals(mixed $expected, mixed $actual)`) that can be used to check if a given value is equal to an expected value.

The [test runner](../framework/Test/TestRunner.php) loads the test case and gets all of its methods.
If a method starts with `test` it counts as a test that is executed.
The test function is than called inside of a try-catch block.
The detection of a failed assertion is done by throwing a [`AssertionFailedException`](../framework/Test/AssertionFailedException.php). 
The catch block of the [test runner](../framework/Test/TestRunner.php) than prints the output to the CLI that the current test case failed and shows the expected and actual value.

-------------------------------------------------------------

## Localization
The global available function `__(string $label)` is just a wrapper for the function `Translator::translate($label)`.

The language used to translate the label is detected the following way:
1. Is the user logged in?
    - Yes: Has the user a language configured?
        - Yes: Use the configured language
        - No: Use the browser language
    - No: Use the browser language
2. Does a language file exists for the requested language (from step 1)?
    - Yes: Keep that language
    - No: Change language to the default/fallback language from configuration
3. Does the requested label exist?
    - Yes: Return the resolved label
    - No: Throw exception (only in dev mode)

-------------------------------------------------------------
