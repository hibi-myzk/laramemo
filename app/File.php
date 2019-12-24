<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * 整形した生成日時
     * 
     * @return string
     */
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])
                ->format('Y/m/d H:i:s');
    }
}
