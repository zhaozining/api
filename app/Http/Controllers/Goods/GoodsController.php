<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Goods as GoodsModel;

class GoodsController extends Controller
{
    public function lists(){
        $res=GoodsModel::get();

        $data=collect($res)->toArray();

        print_r($data);
    }
}
