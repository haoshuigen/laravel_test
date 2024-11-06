<?php

namespace App\Models;

class SqlLog extends BaseModel
{
    protected $fillable = ['user', 'sql', 'time', 'error', 'create_time'];
}
