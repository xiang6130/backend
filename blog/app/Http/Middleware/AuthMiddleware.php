<?php

namespace App\Http\Middleware;

use Closure;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\User;

class AuthMiddleware
{
    public function handle($request, Closure $next)
    {
        switch ($request->path()) {
            case 'doLogin':
                //網頁版使用 須使用陣列方式讀取
                // $account = $request->input("body.login.account");
                // $password = $request->input("body.login.password");

                //postman用
                $account = $request->input("account");
                $password = $request->input("password");

                //把acc&pw送去Controller
                $this->user = new User();
                $response = $this->user->checkUser($account, $password);

                // echo '(進行登入) 帳號' . $account . " " . "密碼" . $password . "\n";

                if (count($response['result']) >= 1) {
                    $emp_id = $response['result'][0]->emp_id;
                    $token = $this->genToken($emp_id);
                    // echo '(登入成功) 帳號:' . $account . " " . "密碼:" . $password . "\n";

                    // $response['emp_id'] = $response['result'][0]->emp_id;
                    $response['token'] = $token;
                    $response['message'] = "登入成功";

                    return response($response, 200);

                    header('Location: index.php');
                } else {
                    echo ($request);
                    return response("帳號密碼驗證失敗", 401);
                }
                break;

            default:
                // $token = $request->headers->all();
                // echo $token['jwttoken'][0]; //一樣

                // echo $request->header('jwttoken');  //一樣
                // return response($token, 200);

                if ($this->checkToken($request)) {
                    return $next($request);
                } else {
                    return response('無效Token', 401);
                }
                break;
        }
    }
    public function checkToken($request)
    {
        $jwtToken = $request->header('jwtToken');
        $secret_key = "YOUR_SECRET_KEY";
        try {
            $payload = JWT::decode($jwtToken, new Key($secret_key, 'HS256'));
            return true;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    private function genToken($emp_id)
    {
        $secret_key = "YOUR_SECRET_KEY";
        $issuer_claim = "http://localhost/final/blog";
        $audience_claim = "http://localhost/final/blog";
        $issuedat_claim = time(); // issued at
        $expire_claim = $issuedat_claim + 1200;
        $payload = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "exp" => $expire_claim,
            "data" => array(
                "emp_id" => $emp_id,
            )
        );
        $jwt = JWT::encode($payload, $secret_key, 'HS256');
        return $jwt;
    }
    public function decodeToken($request)
    {
        $jwtToken = $request->header('jwtToken');
        $secret_key = "YOUR_SECRET_KEY";
        try {
            $payload = JWT::decode($jwtToken, new Key($secret_key, 'HS256'));
            return $payload;
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}
