<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lophoc extends Model
{
    //
    public $timestamps = false;

    protected $table = 'lophoc';
    protected $primaryKey = 'lophoc_id';

    /** cách 2:  hiển thị môn dạy */
    public function lophocmonhocs()
    {
        return $this->hasMany('App\Lophoc_Monhoc', 'lophoc_id', 'lophoc_id');
    }
}
