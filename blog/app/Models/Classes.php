<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Classes
{
    public function getAllClasses()
    {
        $sql = "select class_id, class_name from classes";
        $response = DB::select($sql);
        return $response;
    }
}
?>