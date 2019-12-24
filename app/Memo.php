<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    protected $fillable = [ 'body' ];

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

    /**
     * 整形した更新日時
     * 
     * @return string
     */
    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['updated_at'])
                ->format('Y/m/d H:i:s');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }
}
