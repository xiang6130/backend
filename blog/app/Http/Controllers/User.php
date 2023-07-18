<?php

namespace App\Http\Controllers;

use app\Http\Middleware\AuthMiddleware;
use App\Models\User as UserModel;
use Illuminate\Http\Request;

class User extends Controller
{
    protected $usermodel;
    public function __construct()
    {
        $this->usermodel = new UserModel();
        $this->AM = new AuthMiddleware();
    }
    //測試-----------------------------------------------
    public function getAllUsers()
    {
        // header('Access-Control-Allow-Origin:*'); //for test
        $response['result'] = $this->usermodel->showAll();
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '查詢成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '無查詢結果';
        }
        return $response;
    }
    //個人資料顯示-----------------------------------------------
    public function getUserInfo(Request $request)
    {
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;

        $response['result'] = $this->usermodel->showUser($emp_id);
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '抓取個人資料成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '抓取個人資料失敗或缺少資料';
        }
        return $response;
    }
    //顯示使用者----------------------------------------------
    public function getUser()
    {
        $response['result'] = $this->usermodel->getUser();
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '查詢成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '無查詢結果';
        }
        return $response;
    }
    //刪除使用者---------------------------------------------
    public function deleteUser($emp_id)
    {
       // $emp_id = $request->input("emp_id");
        if ($this->usermodel->deleteUser($emp_id) == 1) {
            $response['status'] = 200;
            $response['message'] = '刪除成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '刪除失敗';
        }
        return $response;
    }
    public function newUser(Request $request)
    {
        $id = $request->input("id");
        $password = $request->input("password");
        $name = $request->input("name");
        $email = $request->input("email");

        if ($this->usermodel->addUser($id, $password, $name, $email) == 1) {
            $response['status'] = 200;
            $response['message'] = '新增成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '新增失敗';
        }
        return $response;
    }
    public function updateUser(Request $request)
    {
        $emp_id = $request->input("emp_id");
        $status = 'fasle';
        if ($this->usermodel->updateUser($emp_id, $status) == 1) {
            $response['status'] = 200;
            $response['message'] = '更新成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '更新失敗';
        }
        return $response;
    }

    public function removeUser(Request $request)
    {
        $id = $request->input("id");
        if ($this->usermodel->removeUser($id) == 1) {
            $response['status'] = 200;
            $response['message'] = '刪除成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '刪除失敗';
        }
        return $response;
    }
    public function checkUser($acc, $pw)
    {
        $response['result'] = $this->usermodel->checkUser($acc, $pw);
        if (count($response['result']) >= 1) {
            $response['status'] = 200;
            $response['message'] = '查詢帳戶成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '無查詢結果';
        }
        return $response;
    }
    public function checkRole($emp_id)
    {
        $response['result'] = $this->usermodel->checkRole($emp_id);
        if (count($response['result']) >= 1) {
            $response['status'] = 200;
            $response['message'] = '查詢角色成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '沒有任何權限';
        }
        return $response;
    }

    public function updatepassword(Request $request)
    {   
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;
        $password = $request->input("password");
        if ($this->usermodel->updatepassword($emp_id,$password) == 1) {
            $response['status'] = 200;
            $response['message'] = '更新成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '更新失敗';
        }
        return $response;
    }
}
