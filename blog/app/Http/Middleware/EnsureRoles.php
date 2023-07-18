<?php
namespace App\Http\Middleware;
use Closure;

class EnsureRoles{
    public function handle($request, Closure $next, ...$roles)
    {   echo "可以執行的角色\n";
         foreach ($roles as $role) {
             echo $role . ", ";
         }
         echo "\n";
         return $next($request);
    }
}
