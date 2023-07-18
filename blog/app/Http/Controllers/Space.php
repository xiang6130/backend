<?php

namespace App\Http\Controllers;

use App\Models\Space as SpaceModel;
use App\Models\Area as AreaModel;
use App\Models\Floor as FloorModel;
use Illuminate\Http\Request;

class Space extends Controller
{
    protected $spacemodel;
    protected $floormodel;
    protected $areamodel;
    public function __construct()
    {
        $this->spacemodel = new SpaceModel();
        $this->floormodel = new FloorModel();
        $this->areamodel = new AreaModel();
    }
    // 顯示所有空間-----------------------------------------------------
    public function getAllRoom($area)
    {
        $response['result'] = $this->spacemodel->showAllRoom($area);
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '查詢成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '無查詢結果';
        }
        return $response;
    }
    //顯示各空間-----------------------------------------------------
    public function getRooms($area = null, $floor = null)
    {
        if($area === null and $floor === null){
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

        else if($floor === null){
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
        else{
            $response['result'] = $this->spacemodel->showRooms($area, $floor);
            if (count($response['result']) != 0) {
                $response['status'] = 200;
                $response['message'] = '查詢空間成功';
            } else {
                $response['status'] = 400;
                $response['message'] = '抓取資料失敗或缺少資料test';
            }
            return $response;
        }
    }
    //刪除各空間-----------------------------------------------
    public function removeRoom($space_id)
    {
        //$space_id = $request->input("space_id");
        if ($this->spacemodel->removeRoom($space_id) == 1) {
            $response['status'] = 200;
            $response['message'] = '刪除成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '刪除失敗';
        }
        return $response;
    }
    //新增各空間
    public function newRoom(Request $request)
    {
        $class_id = $request->input("class_id");
        $area_id = $request->input("area_id");
        $floor_id = $request->input("floor_id");
        $name = $request->input("name");
        $content = $request->input("content");
        $doorlock_name = $request->input("doorlock_name");
        $mac = $request->input("mac");
        $doorlock_password = $request->input("doorlock_password");

        // $area_floor_id = $request->input("area_floor_id");   insert時順便select area_floor_id才對

        if ($this->spacemodel->newRoom($class_id, $area_id, $floor_id, $name, $content, $doorlock_name, $mac, $doorlock_password) == 1) {
            $response['status'] = 200;
            $response['message'] = '新增空間成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '新增空間失敗';
        }
        return $response;
    }
    //修改各空間
    public function updateRoom(Request $request)
    {
        $space_id = $request->input("space_id");
        $name = $request->input("name");
        $content = $request->input("content");
        $doorlock_name = $request->input("doorlock_name");
        $mac = $request->input("mac");
        $doorlock_password = $request->input("doorlock_password");
        $class_id = $request->input("class_id");
        $area_id = $request->input("area_id");
        $floor_id = $request->input("floor_id");
        if ($this->spacemodel->updateRoom($space_id, $name, $content, $doorlock_name, $mac, $doorlock_password, $class_id, $area_id, $floor_id) == 1) {
            $response['status'] = 200;
            $response['message'] = '更新成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '更新失敗';
        }
        return $response;
    }
    //抓樓層跟區域
    public function getfloorandspace()
    {
        $response['result'] = $this->spacemodel->getfloorandspace();
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = "查詢建築物樓層與區域成功";
        } else {
            $response['status'] = 400;
            $response['message'] = '抓取資料失敗或缺少資料';
        }
        return $response;
    }
}
