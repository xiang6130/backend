<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class RoomRecord
{
    //顯示開門紀錄--------------------------------------------------------------
    public function getRoomRecord($area, $floor, $room)
    {
        $sql = "SELECT spaces.name AS room, enter.enter_person,enter.enter_time
        FROM spaces,enter,areas,floors
        WHERE spaces.space_id = enter.space_id
        AND spaces.area_id = areas.area_id
        AND spaces.floor_id = floors.floor_id
        AND areas.name=?
        AND floors.name=?
        AND spaces.name=?;";
        $response = DB::select($sql, [$area, $floor, $room]);
        return $response;
    }
    //顯示所有開門紀錄
    public function getAllRoomRecord()
    {
        $sql = "SELECT spaces.name , enter.enter_person, enter.enter_time FROM spaces,enter WHERE spaces.space_id = enter.space_id;";
        $response = DB::select($sql);
        return $response;
    }
}
?>