<?php

namespace App\Http\Controllers;

use App\Models\Area as AreaModel;
use Illuminate\Http\Request;

class Area extends Controller
{
    protected $areamodel;
    public function __construct()
    {
        $this->areamodel = new AreaModel();
    }
    //顯示建築物----------------------------------------------
    public function getAreas()
    {
        $response['result'] = $this->areamodel->getAreas();
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '查詢建築物成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '無查詢建築物結果';
        }
        return response($response, 200);
    }
}
