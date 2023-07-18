<?php
namespace App\Http\Middleware;
use Closure;

class SecondMiddleware{
    public function handle($request, Closure $next,$arg)
    {   echo "Second Route Middleware:$arg.\n";
         return $next($request);
    }
}


?>