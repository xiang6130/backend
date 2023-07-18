<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Floor
{
    public function getAllFloors()
    {
        $sql = "SELECT floor_id,name FROM `floors` ORDER BY `floor_id`";
        $response = DB::select($sql);
        return $response;
    }
    public function getFloors($area)
    {
        $sql = "SELECT floors.floor_id ,`floors`.`name` 
        FROM `areas`,`floors`,spaces
        WHERE spaces.area_id = areas.area_id
        AND spaces.floor_id = floors.floor_id
        AND areas.name=?
        GROUP BY floors.floor_id,floors.name;";
        $arg = array($area);
        $response = DB::select($sql, $arg);
        return $response;
    }
}
