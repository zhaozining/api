<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    public $table="p_goods";
    protected  $primaryKey="goods_id";
    public $timestamps=false;
    protected  $fillable=["*"];
}
