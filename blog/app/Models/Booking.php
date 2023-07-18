<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Booking
{

    //顯示個人預約紀錄-------------------------------------------------------
    public function showAllBooking($emp_id)
    {
        $sql = "SELECT booking_id, `spaces`.name,`purpose`,`classes`.class_name,`classes`.`person_number`, start_datetime,over_datetime, booking.emp_id, booking.space_id FROM booking,spaces,classes,employee
        WHERE booking.emp_id=employee.emp_id AND booking.emp_id=? and booking.space_id=spaces.space_id and classes.class_id=spaces.class_id ORDER BY booking.over_datetime DESC;";
        $response = DB::select($sql, [$emp_id]);
        return $response;
    }
    //刪除個人預約紀錄--------------------------------------------------------
    public function removeBooking($booking_id)
    {
        $sql = "delete from booking where booking_id=:booking_id";
        $response = DB::delete($sql, ['booking_id' => $booking_id]);
        return $response;
    }
    //顯示單一預約紀錄-----------------------------------------------------------
    public function getBooking($booking_id)
    {
        $sql = "select `spaces`.name,`purpose`,`classes`.class_name,`classes`.`person_number`, start_datetime,over_datetime FROM booking,spaces,classes
                WHERE booking.space_id=spaces.space_id AND booking_id=? and classes.class_id=spaces.class_id;";
        $response = DB::select($sql, [$booking_id]);
        return $response;
    }
    //日曆拖曳------------------------------------------------------------------------------------------
    public function updateBooking1($booking_id, $purpose, $start_datetime, $over_datetime, $emp_id)
    {
        $sql = "update booking set  purpose=:purpose, start_datetime=:start_datetime, over_datetime=:over_datetime where booking_id=:booking_id and emp_id=:emp_id";
        $response = DB::update($sql, ['purpose' => $purpose, 'start_datetime' => $start_datetime, 'over_datetime' => $over_datetime, 'booking_id' => $booking_id, 'emp_id' => $emp_id]);
        return $response;
    }
    //修改預約紀錄----------------------------------------------------------------------------------
    public function updateBooking($booking_id, $purpose, $start_datetime, $over_datetime, $space_id)
    {   
        {   
            $check = "SELECT *
            FROM booking
            WHERE space_id=? 
            AND booking_id != ?
            AND (start_datetime BETWEEN ? AND ?
            OR over_datetime BETWEEN ? AND ?
            OR ? BETWEEN start_datetime AND over_datetime OR
            ? BETWEEN start_datetime AND over_datetime);";
            
            $response = DB::select($check, [$space_id, $booking_id, $start_datetime, $over_datetime, $start_datetime, $over_datetime, $start_datetime, $over_datetime]);
            //$check_response = http_build_query($response);
            if($response == null){
                $start_datetime = date("Y-m-d H:i:s",strtotime("-1 second",strtotime($start_datetime)));
                $over_datetime = date("Y-m-d H:i:s",strtotime("+1 second",strtotime($over_datetime)));
                    $sql = "update booking set  purpose=:purpose, start_datetime=:start_datetime, over_datetime=:over_datetime, space_id=:space_id where booking_id=:booking_id";
                    $response = DB::update($sql, ['purpose' => $purpose, 'start_datetime' => $start_datetime, 'over_datetime' => $over_datetime,'space_id' => $space_id, 'booking_id' => $booking_id]);
                    return $response;
            }
            else{
                return $response;
            }
        }
    }
    //顯示可預約空間(開始~結束datetime)---------------------------------------------------------------------------------
    public function getAllAvailableBooking($space_id)
    {
        $sql = "select `spaces`.name,`classes`.class_name,`classes`.`person_number`, start_datetime as start, over_datetime as end,`booking`.booking_id as booking_id,`booking`.purpose as title ,booking.emp_id from booking,spaces,classes
                where `spaces`.space_id=`booking`.space_id and `booking`.`space_id`=? and spaces.class_id=classes.class_id";
        $response = DB::select($sql, [$space_id]);
        return $response;
    }
    // 新增空間---------------------------------------------------------------------------------
    public function newBooking($emp_id, $space_id, $purpose, $start_datetime, $over_datetime)
    {
        $check = "SELECT space_id 
        FROM booking 
        WHERE ((start_datetime<=? and over_datetime>=?) 
        OR (start_datetime>? and (over_datetime>? and start_datetime<?)) 
        OR ((start_datetime<? and over_datetime>?) and over_datetime<?) 
        OR (start_datetime>=? and over_datetime<=?)) and space_id=?;";
        
        $response = DB::select($check, [$start_datetime, $over_datetime, $start_datetime, $start_datetime, $over_datetime, $over_datetime, $start_datetime, $over_datetime, $start_datetime, $over_datetime , $space_id]);
        $check_response = http_build_query($response);
        //return $check_response;
        if($check_response == null){
                    $sql = "insert into booking (emp_id, space_id, purpose, start_datetime, over_datetime) values (:emp_id, :space_id, :purpose, :start_datetime, :over_datetime )";
                    $response = DB::insert($sql, ['emp_id' => $emp_id, 'space_id' => $space_id, 'purpose' => $purpose, 'start_datetime' => $start_datetime, 'over_datetime' => $over_datetime]);
                    return $response;
    }
    else{
        return $response;
    }
    
    }
}
