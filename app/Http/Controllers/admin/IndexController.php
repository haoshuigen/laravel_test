<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\common\BaseController;
use Illuminate\View\View;

class IndexController extends BaseController
{
    public function index(): View
    {
        return $this->fetch();
    }

    /**
     * 后台首页
     * @return View
     */
    public function welcome(): View
    {
        return $this->fetch('');
    }
}
