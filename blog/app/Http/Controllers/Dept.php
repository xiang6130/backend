<?php
namespace App\Http\Controllers;
use App\Models\Dept as DeptModel;
use Illuminate\Http\Request;

class Dept extends Controller{
    protected $deptmodel;
    public function __construct(){
        $this->deptmodel = new DeptModel();
    }
    //顯示所有部門
    public function getAllDept()
    {
        $response['result'] = $this->deptmodel->getAllDept();
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '查詢成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '無查詢結果';
        }
        return $response;
    }
}
?>