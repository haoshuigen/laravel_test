<?php

namespace App\Http\Services;

use App\Models\SqlLog;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Database\QueryException;

/**
 * 记录所有 Sql Log 服务
 * Class SqlLogService
 * @package app\http\services
 */
class SqlLogService
{
    /**
     * @param Exception|null $e
     * @param string $sql
     * @return void
     */
    public static function record(Exception|null $e, string $sql, float $usedTime = 0): void
    {
        $connectionType = config('database.default');
        $databaseUser = config('database.connections.' . $connectionType . '.username');

        if (!$e instanceof QueryException && empty($sql)) {
            return;
        }

        SqlLog::create([
            'user' => $databaseUser,
            'sql' => !is_null($e) && method_exists($e, 'getSql') ? $e->getSql() : $sql,
            'time' => $usedTime,
            'error' => !is_null($e) ? $e->getMessage() : '',
            'create_time' => time()
        ]);
    }
}
