<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table="user";
    protected  $primaryKey="user_id";
    public $timestamps=false;
    protected  $fillable=["name","pwd","email","phone"];
}
