<?php

namespace App\Models;


class Unit extends BaseModel
{

    protected $auditColumn = true;
    protected $table       = 'units';
    protected $fillable    = ['name', 'status'];

}
