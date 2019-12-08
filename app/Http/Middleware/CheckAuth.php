<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\Token;
use App\User;

class CheckAuth
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
        $data_token = $request->header('Authorization');
        $token = new Token();
        
        $user_email = $token->decode($data_token);
        $user = User::where('email', '=', $user_email)->first();
        $request->request->add(['user' => $user]);
        
        if($user != null)
        {
            return $next($request);
        
        }
    }
}
