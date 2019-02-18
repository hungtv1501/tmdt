<?php

namespace App\Http\Middleware;

use Closure;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // lay tham so ma nguoi dung gui len
        $age = $request->age;
        if($age > 16){
            // cho phep di tiep
            return $next($request);
        } else {
            // bat quay ve trang ko dc xem phim
            return redirect()->route('cancleFilm');
        }
    }
}
