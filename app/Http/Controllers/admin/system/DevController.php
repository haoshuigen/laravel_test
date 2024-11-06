<?php

namespace App\Http\Controllers\admin\system;

use App\Exports\DbDataExport;
use App\Http\Controllers\common\BaseController;
use App\Http\Services\DataService;
use App\Http\Services\SqlLogService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class DevController extends BaseController
{
    public function index(): View|JsonResponse
    {
        if (!request()->ajax()) {
            return $this->fetch();
        }

        $postData = request()->post();
        $sql = str_ireplace(
            ['delete', 'update', 'create', 'drop'],
            '',
            addslashes($postData['content'])
        );

        $dataType = $postData['data_type'] ?? 'raw';

        switch ($dataType) {
            case 'json':
                $returnData = $this->jsonExportResponse($sql);
                break;
            case 'excel':
                $returnData = $this->excelExportResponse($sql);
                break;
            case 'raw':
            default:
                $returnData = $this->rawDataResponse($sql);
        }

        return $returnData;
    }

    /**
     * @param string $sql
     * @return JsonResponse
     */
    private function rawDataResponse(string $sql): JsonResponse
    {
        try {
            $columnArr = [];
            $dbData = DataService::getData($sql);
            $dbData = $dbData ? json_decode(json_encode($dbData), true) : [];
            $cols = isset($dbData[0]) ? array_keys($dbData[0]) : [];
            $code = 1;
            $msg = "ok";

            if (!empty($cols)) {
                foreach ($cols as $col) {
                    $columnArr[] = ['field' => $col, 'title' => $col];
                }
            }
        } catch (Exception $exception) {
            $msg = $exception->getMessage();
            $code = 0;
            $dbData = [];
        }


        $returnData = [
            'code' => $code,
            'msg' => $msg,
            'token' => csrf_token(),
            'cols' => $columnArr,
            'data' => json_decode(json_encode($dbData), true),
        ];

        return json($returnData);
    }

    /**
     * @desc export data to json file
     * @param string $sql
     * @return JsonResponse
     */
    private function jsonExportResponse(string $sql): JsonResponse
    {
        $downloadPath = '';
        try {
            $dbData = DataService::dbCursor($sql);

            $dataArr = [];
            foreach ($dbData as $row) {
                $dataArr[] = (array)$row;
            }

            if ($dataArr) {
                $fileName = date('YmdHis') . uniqid() . '.json';
                $code = 1;
                $msg = "ok";
                Storage::disk('public')->put($fileName, json_encode($dataArr, JSON_UNESCAPED_UNICODE));
                $downloadPath = 'export/' . $fileName;
            } else {
                $code = 0;
                $msg = "no db data";
            }
        } catch (Exception $e) {
            $code = 0;
            $msg = $e->getMessage();
            SqlLogService::record(null, $sql);
        }

        $returnData = [
            'code' => $code,
            'msg' => $msg,
            'token' => csrf_token(),
            'data' => $downloadPath,
        ];

        return json($returnData);
    }

    /**
     * @desc export data to excel file
     * @param string $sql
     * @return JsonResponse
     */
    private function excelExportResponse(string $sql): JsonResponse
    {
        try {
            $downloadPath = '';
            $dataExportObj = new DbDataExport($sql);
            $fileName = date('YmdHis') . uniqid() . '.xlsx';
            Excel::store($dataExportObj, $fileName, 'public');
            $downloadPath = 'export/' . $fileName;
            $code = 1;
            $msg = "ok";
        } catch (Exception $e) {
            $code = 0;
            $msg = $e->getMessage();
        }

        $returnData = [
            'code' => $code,
            'msg' => $msg,
            'token' => csrf_token(),
            'data' => $downloadPath,
        ];

        return json($returnData);
    }
}
