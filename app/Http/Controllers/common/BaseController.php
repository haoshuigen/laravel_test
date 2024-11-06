<?php

namespace App\Http\Controllers\common;

use App\Http\JumpTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class BaseController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, JumpTrait;

    /**
     * @var string
     */
    public string $secondary = '';

    /**
     * @var string
     */
    public string $controller = '';

    /**
     * @var string
     */
    public string $action = '';

    /**
     * @var array
     */
    public array $adminConfig = [];

    public function __construct()
    {
        $this->initialize();
    }

    // 初始化
    protected function initialize(): void
    {
        $parameters = request()->route()->parameters ?? [];
        $this->adminConfig = $adminConfig = config('admin');
        $secondary = $parameters['secondary'] ?? '';
        $controller = $parameters['controller'] ?? 'index';
        $action = $parameters['action'] ?? 'index';
        $this->secondary = $secondary;
        $this->controller = $controller;
        $this->action = $action;
        $jsBasePath = ($secondary ? "{$secondary}/" : '') . strtolower($controller);
        $thisControllerJsPath = "admin/js/{$jsBasePath}.js";
        $autoloadJs = file_exists($thisControllerJsPath);
        $adminModuleName = $adminConfig['admin_alias_name'];
        $isSuperAdmin = session('admin.id') == $adminConfig['super_admin_id'];

        $data = [
            'isSuperAdmin' => $isSuperAdmin,
            'adminModuleName' => $adminModuleName,
            'thisController' => $controller,
            'thisAction' => $action,
            'thisRequest' => "{$adminModuleName}/{$controller}/{$action}",
            'thisControllerJsPath' => $thisControllerJsPath,
            'autoloadJs' => $autoloadJs,
            'version' => '1.0.0',
        ];

        $this->assign($data);
    }

    /**
     * @param array $args
     */
    public function assign(array $args = []): void
    {
        \Illuminate\Support\Facades\View::share($args);
    }

    public function fetch(string $template = '', array $args = []): View
    {
        if (empty($template)) {
            $basePath = ".{$this->controller}.{$this->action}";
            if ($this->secondary) {
                $template = 'admin.' . $this->secondary . $basePath;
            } else {
                $template = 'admin' . $basePath;
            }
        }
        return view($template, $args);
    }
}
