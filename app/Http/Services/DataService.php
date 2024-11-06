<?php

namespace App\Http\Services;

use Exception;
use Generator;
use Illuminate\Support\Facades\DB;

class DataService
{
    /**
     * @desc execute user's input sql
     * @param string $sql
     * @return array
     * @throws Exception
     */
    public static function getData(string $sql): array
    {
        try {
            $sql = stripos($sql, 'limit ') === false ? $sql . ' LIMIT 0,1000' : $sql;
            return Db::select($sql);
        } catch (Exception $exception) {
            SqlLogService::record($exception, $sql);
            throw $exception;
        }
    }

    /**
     * @param string $sql
     * @return Generator
     * @throws Exception
     */
    public static function dbCursor(string $sql): Generator
    {
        return Db::cursor($sql);
    }
}
