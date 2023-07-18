<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;

class Dept
{
    public function getAllDept()
    {
        $sql = "select dept_name from dept";
        $response = DB::select($sql);
        return $response;
    }
}
?>