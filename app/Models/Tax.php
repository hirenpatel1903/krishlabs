<?php

namespace App\Models;


class Tax extends BaseModel
{

    protected $auditColumn = true;
    protected $table       = 'taxs';
    protected $fillable    = ['name','code','tax_rate','type','shop_id','status'];

}
