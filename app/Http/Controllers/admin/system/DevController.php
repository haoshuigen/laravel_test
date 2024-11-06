<?php

namespace App\Http\Controllers\admin\system;

use App\Exports\DbDataExport;
use App\Http\Controllers\common\BaseController;
use App\Http\Services\DataService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class DevController extends BaseController
{
    public function index(): View
    {
        return $this->fetch();
    }
}
