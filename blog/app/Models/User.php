<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class User
{
    public function showAll()
    {
        $sql = "select * from employee";
        $response = DB::select($sql);
        return $response;
    }
    //個人資料顯示------------------------------------------------------
    public function showUser($emp_id)
    {
        $sql = "SELECT emp_id,emp_name,dept.dept_id,dept.dept_name,email,password FROM employee,dept WHERE employee.dept_id=dept.dept_id  and employee.emp_id=?;";
        $response = DB::select($sql, [$emp_id]);
        return $response;
    }
    //顯示使用者-----------------------------------------------------------
    public function getUser()
    {
        $sql = "SELECT employee.emp_id,employee.emp_name,dept_name,email as account, employee.status FROM employee,dept WHERE dept.dept_id=employee.dept_id ORDER by employee.emp_id asc";
        $response = DB::select($sql);
        return $response;
    }
    //刪除使用者-------------------------------------------------------------
    public function deleteUser($emp_id)
    {
        $sql = "delete from employee where emp_id=:emp_id";
        $response = DB::delete($sql, ['emp_id' => $emp_id]);
        return $response;
    }
    public function addUser($id, $password, $name, $email)
    {
        $sql = "insert into employee (id, password, name, email) values (:id, :password, :name, :email)";
        $response = DB::insert($sql, ['id' => $id, 'password' => $password, 'name' => $name, 'email' => $email]);
        return $response;
    }
    //修改離職
    public function updateUser($emp_id, $status)
    {
        $sql = "update employee set  status=:status where emp_id=:emp_id";
        $response = DB::update($sql, ['emp_id' => $emp_id,  'status' =>$status]);
        return $response;
    }
    public function removeUser($id)
    {
        $sql = "delete from employee where id=:id";
        $response = DB::delete($sql, ['id' => $id]);
        return $response;
    }
    public function checkUser($acc, $pw)
    {
        $sql = "SELECT emp_id, email, employee.password, name FROM employee,role,employee_role WHERE  role.role_id = employee_role.role_id and employee_role.employee_id = employee.emp_id and employee.email=? AND employee.password=?";
        $arg = array($acc, $pw);
        return DB::select($sql, $arg);
    }
    public function checkRole($emp_id)
    {
        $sql = "SELECT role.name FROM `employee_role`,`employee`,`role` WHERE employee_role.employee_id=employee.emp_id and employee_role.role_id=role.role_id and employee.emp_id=?;";
        $arg = array($emp_id);
        return DB::select($sql, $arg);
    }
    public function updatepassword($emp_id, $password)
    {
        $sql = "update employee set  password=:password where emp_id=:emp_id";
        $response = DB::update($sql, ['emp_id' => $emp_id,  'password' => $password]);
        return $response;
    }
}
