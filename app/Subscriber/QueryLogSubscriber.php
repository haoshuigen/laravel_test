<?php

namespace App\Subscriber;


use App\Http\Services\SqlLogService;
use App\Models\SqlLog;
use Illuminate\Support\Facades\DB;

/**
 * @Desc Monitor All SQL Execution
 */
class QueryLogSubscriber
{
    public function __construct()
    {
        DB::listen(function ($query) {
            if (stripos($query->sql, 'sql_log') === false) {
                $sql = $query->sql;
                $bindings = $query->bindings;
                $usedTime = $query->time;

                foreach ($bindings as $replace) {
                    $sql = preg_replace('/\?/', "'" . $replace . "'", $sql, 1);
                }

                SqlLogService::record(null, $sql, $usedTime);
            }
        });
    }
}
