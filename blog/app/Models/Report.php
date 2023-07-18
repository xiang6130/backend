<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Report
{
    //新增回饋----------------------------------------------------------------------------------------
    public function newReport($emp_id, $space_id, $content, $report_time, $dealwith)
    {
        $sql = "insert into report (emp_id, space_id, content, report_time, dealwith) values (:emp_id, :space_id, :content, :report_time, :dealwith)";
        $response = DB::insert($sql, ['emp_id' => $emp_id, 'space_id' => $space_id, 'content' => $content, 'report_time' => $report_time, 'dealwith' => $dealwith]);
        return $response;
    }
    //問題回饋管理-------------------------------------------------------------------------------------
    public function getUserReport()
    {
        $sql = "SELECT spaces.name AS room,employee.emp_name,report.report_time,report.content,report.dealwith,report.report_id
        FROM spaces,employee,report
        WHERE spaces.space_id =report.space_id
        AND report.emp_id = employee.emp_id
        ORDER by report.report_time DESC;";
        $response = DB::select($sql);
        return $response;
    }
    //問題回饋勾選
    public function updatedealwith($report_id, $dealwith)
    {
        $sql = "update report set  dealwith=:dealwith where report_id=:report_id";
        $response = DB::update($sql, ['dealwith' => $dealwith,  'report_id' => $report_id]);
        return $response;
    }
}
