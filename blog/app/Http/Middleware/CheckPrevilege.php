<?php

namespace App\Http\Middleware;

use Closure;

class CheckPrevilege
{
    public function handle($request, Closure $next)
    {
        $this->AM = new AuthMiddleware();
        $payload = $this->AM->decodeToken($request);
        $emp_id = $payload->data->emp_id;

        $role = $request->header('role');
        $isAuthorized = ($role == "admin") ? true : false;
        if ($isAuthorized) {
            return $next($request);
        } else {
            return response('權限不足', 401);
        }
    }
}
