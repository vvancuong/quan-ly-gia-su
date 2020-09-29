<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lophoc_Monhoc extends Model
{
    //
    //
    public $timestamps = false;

    protected $table = 'lophoc_monhoc';
    protected $primaryKey = 'lophoc_monhoc_id';
    public function monhoc($monhocid)
    {
        return $this->hasOne('App\Monhoc', 'monhoc_id', 'monhoc_id');
    }
}
