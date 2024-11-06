<?php

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Middleware\CheckAuth;
use App\Http\Controllers\admin\IndexController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/download/{path}', [\App\Http\Controllers\DownloadController::class, 'index'])->where('path', '.*');

$admin = config('admin.admin_alias_name');

Route::middleware([CheckAuth::class])->group(function () use ($admin) {
    Route::prefix($admin)->group(function () {

        // Admin index route
        Route::get('/', [IndexController::class, 'index']);

        $adminNamespace = config('admin.controller_namespace');
        // Dynamic route (match secondary/controller.action)
        Route::match(['get', 'post'], '/{secondary}.{controller}/{action}', function ($secondary, $controller, $action) use ($adminNamespace) {

            $namespace = $adminNamespace . $secondary . '\\';
            $className = $namespace . ucfirst($controller . "Controller");
            $className = Str::studly($className);
            if (class_exists($className)) {
                $obj = new $className();
                if (method_exists($obj, $action)) {
                    $reflectionClass = new ReflectionClass($className);
                    $actionMethod = $reflectionClass->getMethod($action);
                    $args = [];
                    foreach ($actionMethod->getParameters() as $items) {
                        try {
                            if ($items->hasType()) {
                                $type = $items->getType()->getName();
                                $args[] = str_contains($type, 'App\\') ? new $type() : Container::getInstance()->make($type);
                            } else {
                                $args[] = request($items->getName(), '');
                            }
                        } catch (Throwable $exception) {
                            json([
                                'code' => 0,
                                'msg' => $exception->getMessage(),
                                'error' => 'system error'
                            ]);
                        }
                    }
                    return call_user_func([$obj, $action], ...$args);
                }
            }
            abort(404);
        });

        // 动态路由 (匹配 controller)
        Route::match(['get', 'post'], '/{controller}/', function ($controller) use ($adminNamespace) {
            $namespace = $adminNamespace;
            $className = $namespace . ucfirst($controller . "Controller");
            $action = 'index';
            if (class_exists($className)) {
                $obj = new $className();
                if (method_exists($obj, $action)) {
                    $reflectionClass = new ReflectionClass($className);
                    $actionMethod = $reflectionClass->getMethod($action);
                    $args = [];
                    foreach ($actionMethod->getParameters() as $items) {
                        try {
                            if ($items->hasType()) {
                                $type = $items->getType()->getName();
                                $args[] = str_contains($type, 'App\\') ? new $type() : Container::getInstance()->make($type);
                            } else {
                                $args[] = request($items->getName(), '');
                            }
                        } catch (Throwable $exception) {
                            json([
                                'code' => 0,
                                'msg' => $exception->getMessage(),
                                'error' => 'system error'
                            ]);
                        }
                    }
                    return call_user_func([$obj, $action], ...$args);
                }
            }
            abort(404);
        });

        // Dynamic (match controller/action)
        Route::match(['get', 'post'], '/{controller}/{action}', function ($controller, $action) use ($adminNamespace) {
            $namespace = $adminNamespace;
            $className = $namespace . ucfirst($controller . "Controller");
            if (class_exists($className)) {
                $obj = new $className();
                if (method_exists($obj, $action)) {
                    $reflectionClass = new ReflectionClass($className);
                    $actionMethod = $reflectionClass->getMethod($action);
                    $args = [];
                    foreach ($actionMethod->getParameters() as $items) {
                        try {
                            if ($items->hasType()) {
                                $type = $items->getType()->getName();
                                $args[] = str_contains($type, 'App\\') ? new $type() : Container::getInstance()->make($type);
                            } else {
                                $args[] = request($items->getName(), '');
                            }
                        } catch (Throwable $exception) {
                            json([
                                'code' => 0,
                                'msg' => $exception->getMessage(),
                                'error' => 'system error'
                            ]);
                        }
                    }
                    return call_user_func([$obj, $action], ...$args);
                }
            }
            abort(404);
        });

    });
});
