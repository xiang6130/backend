<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Area
{
    public function getAreas()
    {
        $sql = "SELECT area_id,name FROM `areas` ORDER BY `area_id`";
        $response = DB::select($sql);
        return $response;
    }
}
