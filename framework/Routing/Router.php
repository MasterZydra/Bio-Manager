<?php

namespace Framework\Routing;

use Closure;
use Exception;

/**
 * Route the request to the correct view or controller.
 * Based on https://steampixel.de/einfaches-und-elegantes-url-routing-mit-php/
 */
class Router
{
    private static array $routes = [];
    private static ?Closure $pathNotFound = null;
    private static ?Closure $methodNotAllowed = null;

    /** Register new routes for showing, creating, editing, etc. models */
    public static function addModel(string $expression, ModelControllerInterface $controller): void
    {
        foreach (['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'] as $route) {
            if (!method_exists($controller, $route)) {
                continue;
            }
            $modifiedExpression = '/' . rtrim(ltrim($expression, '/'), '/') . '/' . $route;
            if ($route === 'index') {
                $modifiedExpression = '/' . ltrim($expression, '/');
            }
            array_push(
                self::$routes,
                [
                    'expression' => $modifiedExpression,
                    'controller' => $controller,
                    'controllerFn' => $route,
                    'method' => self::getMethodForRoute($route),
                ]
            );
        }
    }

    /** Register new route and the given controller will be executed if the route is requested */
    public static function addController(string $expression, ControllerInterface $controller, string $method = 'GET'): void
    {
        array_push(
            self::$routes,
            [
                'expression' => '/' . ltrim($expression, '/'),
                'controller' => $controller,
                'method' => $method,
            ]
        );
    }

    /** Register new route and the given closure will be executed if the route is requested */
    public static function addFn(string $expression, Closure $function, string $method = 'GET'): void
    {
        array_push(
            self::$routes,
            [
                'expression' => '/' . ltrim($expression, '/'),
                'function' => $function,
                'method' => $method,
            ]
        );
    }

    /** Define the behaviour for 404 */
    public static function pathNotFound(Closure $function): void
    {
        self::$pathNotFound = $function;
    }

    /** Define the behaviour for 405 */
    public static function methodeNotAllowed(Closure $function): void
    {
        self::$methodNotAllowed = $function;
    }

    /** Search in the list of routes for the requested URI and call that route */
    public static function run(string $basepath = '/')
    {
        // Parse current url
        $parsed_url = parse_url($_SERVER['REQUEST_URI']); //Parse Uri

        if (isset($parsed_url['path'])) {
            $path = $parsed_url['path'];
        } else {
            $path = '/';
        }

        // Get current request method
        $method = $_SERVER['REQUEST_METHOD'];

        $path_match_found = false;

        $route_match_found = false;

        foreach (self::$routes as $route) {

            // If the method matches check the path

            // Add basepath to matching string
            if ($basepath != '' && $basepath != '/') {
                $route['expression'] = '(' . $basepath . ')' . $route['expression'];
            }

            // Add 'find string start' automatically
            $route['expression'] = '^' . $route['expression'];

            // Add 'find string end' automatically
            $route['expression'] = $route['expression'] . '$';

            // Check path match	
            if (preg_match('#' . $route['expression'] . '#', $path, $matches)) {

                $path_match_found = true;

                // Check method match
                if (strtolower($method) == strtolower($route['method'])) {

                    array_shift($matches); // Always remove first element. This contains the whole string

                    if ($basepath != '' && $basepath != '/') {
                        array_shift($matches); // Remove basepath
                    }

                    if (array_key_exists('function', $route)) {
                        call_user_func_array($route['function'], $matches);
                        return;
                    }

                    if (array_key_exists('controller', $route)) {
                        /** @var ControllerInterface $controller */
                        $controller =  $route['controller'];
                        if (array_key_exists('controllerFn', $route)) {
                            $controllerFn = $route['controllerFn'];
                            $controller->$controllerFn();
                            return;
                        } else {
                            $controller->execute();
                            return;
                        }
                    }

                    $route_match_found = true;

                    // Do not check other routes
                    break;
                }
            }
        }

        // No matching route was found
        if (!$route_match_found) {
            // But a matching path exists
            if ($path_match_found) {
                header("HTTP/1.0 405 Method Not Allowed");
                if (self::$methodNotAllowed) {
                    call_user_func_array(self::$methodNotAllowed, array($path, $method));
                }
            } else {
                header("HTTP/1.0 404 Not Found");
                if (self::$pathNotFound) {
                    call_user_func_array(self::$pathNotFound, array($path));
                }
            }
        }
    }

    /** Get the HTTP method for the given resource route */
    private static function getMethodForRoute(string $route): string
    {
        switch ($route) {
            case 'create':
            case 'edit':
            case 'index':
            case 'show':
                return 'GET';
            case 'destroy':
            case 'store':
            case 'update':
                return 'POST';
            default:
                throw new Exception('Route "' . $route . '" is not implemented');
        }
    }
}
