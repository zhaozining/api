<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $table="token";
    protected  $primaryKey="id";
    public $timestamps=false;
    protected  $fillable=["token","time","out_time"];
}
