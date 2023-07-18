<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthMiddleware;
use App\Models\Report as ReportModel;
use Illuminate\Http\Request;

class Report extends Controller
{
    protected $reportmodel;
    public function __construct()
    {
        $this->reportmodel = new ReportModel();
        $this->AM = new AuthMiddleware();
    }
    //新增回報----------------------------------------------------------------------------------
    public function newReport(Request $request)
    {   date_default_timezone_set('Asia/Taipei');
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;
        $space_id = $request->input('space_id');
        $content = $request->input('content');
        $report_time = date("Y-m-d H:i:s");
        $dealwith = 'false';
        if ($this->reportmodel->newReport($emp_id, $space_id, $content, $report_time, $dealwith) == 1) {
            $response['status'] = 200;
            $response['message'] = '新增問題成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '新增問題失敗';
        }
        return $response;
    }
    //問題回饋管理-------------------------------------------------------------------------------
    public function getUserReport()
    {
        $response['result'] = $this->reportmodel->getUserReport();
        if (count($response['result']) != 0) {
            $response['status'] = 200;
            $response['message'] = '查詢成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '無查詢結果';
        }
        return $response;
    }
    //問題回饋勾選
    public function updatedealwith(Request $request)
    {
        $report_id = $request->input("report_id");
        $dealwith = 'true';
        if ($this->reportmodel->updatedealwith($report_id, $dealwith) == 1) {
            $response['status'] = 200;
            $response['message'] = '更新成功';
        } else {
            $response['status'] = 204;
            $response['message'] = '更新失敗';
        }
        return $response;
    }
}
