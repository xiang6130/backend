<?php
namespace App\Http\Controllers;
use App\Models\Classes as ClassesModel;
use Illuminate\Http\Request;

class Classes extends Controller{
    protected $classesmodel;
    public function __construct(){
        $this->classesmodel = new ClassesModel();
    }
    //顯示所有部門
    public function getAllClasses()
    {
        $response['result'] = $this->classesmodel->getAllClasses();
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