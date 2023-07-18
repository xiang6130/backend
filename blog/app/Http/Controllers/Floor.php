<?php

namespace App\Http\Controllers;

use App\Models\Floor as FloorModel;
use Illuminate\Http\Request;

class Floor extends Controller
{
    protected $floormodel;
    public function __construct()
    {
        $this->floormodel = new FloorModel();
    }
    //顯示所有樓層(admin)----------------------------------------------
    public function getAllFloors()
    {
        $response['result'] = $this->floormodel->getAllFloors();
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '查詢所有樓層成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '無查詢結果';
        }
        return $response;
    }
    //顯示可預約空間(樓層)-----------------------------------------------------
    public function getFloors($area)
    {
        $response['result'] = $this->floormodel->getFloors($area);
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = "查詢建築物樓層成功";
        } else {
            $response['status'] = 400;
            $response['message'] = '抓取資料失敗或缺少資料';
        }
        return $response;
    }
}
