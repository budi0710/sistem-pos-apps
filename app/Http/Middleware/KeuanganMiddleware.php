<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KeuanganMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $role = $request->session()->get('user_role');

       return  ($role==3) ?  $next($request) : redirect('404page');
    
        // Izinkan jika role adalah 1 atau 2
        if (in_array($role, [1, 2])) {
            return $next($request);
        }
        return redirect('404page');
    }
}
