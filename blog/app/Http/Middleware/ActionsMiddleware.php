<?php

namespace App\Http\Middleware;

use App\Http\Controllers\User;
use Closure;

class ActionsMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $this->AM = new AuthMiddleware();
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;

        //把emp_id送去Controller
        $this->user = new User();
        $response = $this->user->checkRole($emp_id);
        $role = $response['result'][0]->name;
        $role_intersect = array_intersect($roles, [$role]);
        $isAuthorized = (count($role_intersect) > 0) ? true : false;
        if ($isAuthorized) {
            return $next($request);
        } else {
            $response['result'] = [];
            $response['status'] = 401;
            $response['message'] = "權限不足";
            return response($response, 401);
        }
    }
}
