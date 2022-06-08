<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Shipu\Watchable\Traits\WatchableTrait;

class BaseModel extends Model
{
    use WatchableTrait;
}
