<?php

namespace App\Http\Middleware;

use Closure;

class ExampleTest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $params)
    {
        // $params == role
        $user = $request->user;
        $pass = $request->pass;

        if($this->checkLoginDemo($user, $pass) && $params === 'superAdmin'){
            return $next($request);
        }

        return redirect()->route('error-login');
       
    }

    private function checkLoginDemo($username, $password)
    {
        if ($username === 'admin' && $password === '123') {
            return true;
        }
        return false;
    }
}
