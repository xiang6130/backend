<?php
namespace App\Http\Controllers;
use App\Models\RoomRecord as RoomRecordModel;
use Illuminate\Http\Request;

class RoomRecord extends Controller{
    protected $roomrecordmodel;
    public function __construct(){
        $this->roomrecordmodel = new RoomRecordModel();
    }
    //顯示開門紀錄
    public function getRoomRecord($area, $floor, $room){
        $response['result'] = $this->roomrecordmodel->getRoomRecord($area, $floor, $room);
        if(count($response['result'])!=0){
            $response['status'] = 200;
            $response['message'] = '查詢空間成功';
        }
        else{
            $response['status'] = 400;
            $response['message'] = '抓取資料失敗或缺少資料';
        }
        return $response;

      }
      //顯示所有開門紀錄
      public function getAllRoomRecord(){
        $response['result'] = $this->roomrecordmodel->getAllRoomRecord();
        if(count($response['result'])!=0){
            $response['status'] = 200;
            $response['message'] = '查詢空間成功';
        }
        else{
            $response['status'] = 400;
            $response['message'] = '抓取資料失敗或缺少資料';
        }
        return $response;

      }
}
?>