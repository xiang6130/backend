<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Space
{
    //顯示各空間-------------------------------------------------------------------------
    public function showAllRoom($area)
    {
        $sql = "SELECT `spaces`.space_id AS space_id,areas.area_id AS area_id,floors.floor_id AS floor_id,`spaces`.doorlock_password AS doorlock_password,`spaces`.name AS space_name,`classes`.`class_id`,`classes`.`class_name`,`floors`.`name` AS floor ,`areas`.`name` AS area ,content,doorlock_name,mac,person_number
        FROM `spaces`,`classes`,`floors`,`areas`
        WHERE `spaces`.class_id=`classes`.class_id
        and `floors`.floor_id=`spaces`.floor_id
        and `areas`.`area_id`=`spaces`.`area_id`
        and areas.name=?
        ORDER by `spaces`.space_id asc;";
        $arg = array($area);
        $response = DB::select($sql, $arg);
        return $response;
    }
    //顯示可預約空間(空間)------------------------------------------------------
    public function showRooms($area, $floor)
    {
        $sql = "SELECT spaces.name,content,class_name,person_number,`spaces`.space_id ,areas.area_id,floors.floor_id
        FROM `spaces`,`classes`,areas,floors 
        WHERE spaces.area_id = areas.area_id
        AND spaces.floor_id = floors.floor_id
        AND spaces.class_id=classes.class_id
        and `areas`.`name`=? and `floors`.`name`=?;";
        $response = DB::select($sql, [$area, $floor]);
        return $response;
    }
    //刪除各空間-----------------------------------------------------------------
    public function removeRoom($space_id)
    {
        $sql = "delete from spaces where space_id=:space_id";
        $response = DB::delete($sql, ['space_id' => $space_id]);
        return $response;
    }
    //新增各空間-----------------------------------------------------------------
    public function newRoom($class_id, $area_id, $floor_id, $name, $content, $doorlock_name, $mac, $doorlock_password)
    {
        $check ="SELECT spaces.name
        FROM spaces
        WHERE spaces.name=?;";
        $response = DB::select($check, [$name]);

        if($response == null){
            $sql = "insert into spaces (class_id, area_id, floor_id, name, content, doorlock_name, mac, doorlock_password) values (:class_id, :area_id, :floor_id, :name, :content, :doorlock_name, :mac, :doorlock_password)";
            $response = DB::insert($sql, ['name' => $name, 'content' => $content, 'doorlock_name' => $doorlock_name, 'mac' => $mac, 'doorlock_password' => $doorlock_password, 'class_id' => $class_id, 'area_id' => $area_id, 'floor_id' => $floor_id]);
            return $response;
        }
        else{
            return $response;
        }
    }
    public function updateSpace($id, $password, $name, $email)
    {   
        $check ="SELECT spaces.name
        FROM spaces
        WHERE spaces.name=?;";
        $response = DB::select($check, [$name]);

        if($response == null){
            $sql = "update space set  password=:password, name=:name, email=:email where id=:id";
            $response = DB::update($sql, ['id' => $id, 'name' => $name, 'password' => $password, 'email' => $email]);
            return $response;
        }
        else{
            return $response;
        }

    }
    //修改各空間
    public function updateRoom($space_id, $name, $content, $doorlock_name, $mac, $doorlock_password, $class_id, $area_id, $floor_id)
    {
        

        $check_name = "SELECT spaces.name
                    FROM spaces
                    WHERE spaces.name=?
                    ";
        $check_response1 = DB::select($check_name, [$name]);

        $check_id = "SELECT spaces.space_id
                    FROM spaces
                    WHERE spaces.name=?
                    AND spaces.space_id=?
                    ";
        $check_response2 = DB::select($check_id, [$name, $space_id]);
       

        if($check_response1 == null){
            $sql = "update spaces set name=:name, content=:content, doorlock_name=:doorlock_name, mac=:mac, doorlock_password=:doorlock_password,class_id=:class_id,area_id=:area_id,floor_id=:floor_id where space_id =:space_id ";
            $response = DB::update($sql, ['space_id' => $space_id, 'name' => $name, 'content' => $content, 'doorlock_name' => $doorlock_name, 'mac' => $mac, 'doorlock_password' => $doorlock_password, 'class_id' => $class_id, 'area_id' => $area_id, 'floor_id' => $floor_id]);
            return $response;
        }elseif($check_response2 != null){
            $sql = "update spaces set name=:name, content=:content, doorlock_name=:doorlock_name, mac=:mac, doorlock_password=:doorlock_password,class_id=:class_id,area_id=:area_id,floor_id=:floor_id where space_id =:space_id ";
            $response = DB::update($sql, ['space_id' => $space_id, 'name' => $name, 'content' => $content, 'doorlock_name' => $doorlock_name, 'mac' => $mac, 'doorlock_password' => $doorlock_password, 'class_id' => $class_id, 'area_id' => $area_id, 'floor_id' => $floor_id]);
            return $response;
        }

        else{
            return $check_response1;
        }   

    }

    public function getfloorandspace()
    {
        $sql = "SELECT area_floor.area_floor_id , areas.name as area, floors.name as floor FROM area_floor,areas,floors WHERE area_floor.area_id=areas.area_id AND area_floor.floor_id=floors.floor_id ";
        $response = DB::select($sql);
        return $response;
    }
}
