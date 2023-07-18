<?php
namespace App\Http\Middleware;
use Closure;

class FirstMiddleware{
    public function handle($request, Closure $next,$arg)
    {   echo "First Route Middleware:$arg.\n";
         return $next($request);
    }
}


?>