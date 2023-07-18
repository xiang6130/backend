<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthMiddleware;
use App\Models\Booking as BookingModel;
use Illuminate\Http\Request;

class Booking extends Controller
{
    protected $bookingmodel;
    public function __construct()
    {
        $this->bookingmodel = new BookingModel();
        $this->AM = new AuthMiddleware();
    }

    //顯示個人預約資料------------------------------------------
    public function getAllBooking(Request $request)
    {
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;
        $response['result'] = $this->bookingmodel->showAllBooking($emp_id);
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '資料取得成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '資料取得失敗';
        }
        return $response;
    }
    //刪除個人預約紀錄-------------------------------------------
    public function removeBooking($booking_id)
    {
        //$booking_id = $request->input("booking_id");
        if ($this->bookingmodel->removeBooking($booking_id) == 1) {
            $response['status'] = 200;
            $response['message'] = '刪除成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '刪除失敗';
        }
        return $response;
    }
    //顯示單一預約紀錄-----------------------------------------------------------
    public function getBooking($booking_id)
    {
        $response['result'] = $this->bookingmodel->getBooking($booking_id);
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '資料取得成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '資料取得失敗';
        }
        return $response;
    }
    //日曆拖曳-------------------------------------------------------------------
    public function updateBooking1(Request $request)
    {
        date_default_timezone_set('Asia/Taipei');
        $booking_id = $request->input("booking_id");
        $purpose = $request->input("purpose");

        $start_datetime1 = $request->input("start_datetime");
        $start_datetime = date("Y-m-d H:i:s",strtotime("-8 hour",strtotime($start_datetime1)));

        $over_datetime1 = $request->input("over_datetime");
        $over_datetime = date("Y-m-d H:i:s",strtotime("-8 hour",strtotime($over_datetime1)));

        $now_time = date("Y-m-d H:i:s");
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;
            if($over_datetime > $start_datetime){
                if($start_datetime >= $now_time){
                    if ($this->bookingmodel->updateBooking1($booking_id, $purpose, $start_datetime, $over_datetime, $emp_id) == 1) {
                        $response['status'] = 200;
                        $response['message'] = '更新成功';
                    } else {
                        $response['status'] = 204;
                        $response['message'] = '無修改權限 非原預約人';
                    }
                }
                else{
                    $response['status'] = 208;
                    $response['message'] = '更新失敗 起始時間不可早於當前時間';
                }
            }
            else{
                $response['status'] = 206;
                $response['message'] = '更新失敗 結束時間在開始時間之前';
            }
        return $response;
    }
//修改預約紀錄----------------------------------------------------------------------------------
    public function updateBooking(Request $request)
    {
        //date_default_timezone_set('Asia/Taipei');
        $booking_id = $request->input("booking_id");
        $purpose = $request->input("purpose");
        $start_datetime1 = $request->input("start_datetime");
        $start_datetime = date("Y-m-d H:i:s",strtotime("+1 second",strtotime($start_datetime1)));

        $over_datetime1 = $request->input("over_datetime");
        $over_datetime = date("Y-m-d H:i:s",strtotime("-1 second",strtotime($over_datetime1)));
        $now_time = date("Y-m-d H:i:s");
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;
        $space_id = $request->input("space_id");
            if($over_datetime > $start_datetime){
                if($start_datetime >= $now_time){
                    if ($this->bookingmodel->updateBooking($booking_id, $purpose, $start_datetime, $over_datetime, $space_id, $emp_id) == 1) {
                        $response['status'] = 200;
                        $response['message'] = '更新成功';
                    } else {
                        $response['status'] = 204;
                        $response['message'] = '更新失敗';
                    }
                }
                else{
                    $response['status'] = 208;
                    $response['message'] = '更新失敗 起始時間不可早於當前時間';
                }
            }
            else{
                $response['status'] = 206;
                $response['message'] = '更新失敗 結束時間在開始時間之前';
            }
        
        
        return $response;
    }
    //顯示可預約空間---------------------------------------------------------------------------------
    public function getAllAvailableBooking($space_id)
    {
        $response['result'] = $this->bookingmodel->getAllAvailableBooking($space_id);
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '資料取得成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '資料取得失敗';
        }
        return $response;
    }
    //新增預約空間---------------------------------------------------------------------------------
    public function newBooking(Request $request)
    {
        // $emp_id = $request->input('emp_id'); //for test
        date_default_timezone_set('Asia/Taipei');
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;
        $space_id = $request->input('space_id');
        $purpose = $request->input('purpose');
        $start_datetime = $request->input('start_datetime');
        $over_datetime = $request->input('over_datetime');
        $now_time = date("Y-m-d H:i:s");
        

        if($over_datetime > $start_datetime){
            if($start_datetime >= $now_time){
                if ($this->bookingmodel->newBooking($emp_id, $space_id, $purpose, $start_datetime, $over_datetime) == 1) {
                    $response['status'] = 200;
                    $response['message'] = '新增預約成功';
                } else {
                    $response['status'] = 204;
                    $response['message'] = '新增失敗 預約時間衝突';
                }
            }
            else{
                $response['status'] = 208;
                $response['message'] = '新增失敗 起始時間不可早於現在時間';
            }
        }
        else{
            $response['status'] = 206;
            $response['message'] = '結束時間在開始時間之前';
        }
        return $response;
    }
}
