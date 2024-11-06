<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\common\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Http\Services\MenuService;

class AjaxController extends BaseController
{
    /**
     * @desc 初始化导航
     * @return JsonResponse
     */
    public function initAdmin(): JsonResponse
    {
//        $cacheData = Cache::get('initAdmin_' . session('admin.id'));
        $cacheData = [];
        if (!empty($cacheData)) {
            return json($cacheData);
        }
        $menuService = new MenuService(session('admin.id'));
        $data        = [
            'logoInfo' => [
                'title' => config('admin.admin_site_name'),
                'image' => '',
                'href'  => __url(),
            ],
            'homeInfo' => $menuService->getHomeInfo(),
            'menuInfo' => $menuService->getMenuTree(),
        ];
//        Cache::put('initAdmin_' . session('admin.id'), $data);
        return json($data);
    }
}
