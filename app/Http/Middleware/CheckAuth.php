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
        $header_token = $request->header('Authorization');

        if(isset($header_token))
        {
            $token = new Token();
            $decode_token = $token->decode($header_token);

            $user_email = User::where('email', $decode_token)->first();

            if(isset($user_email))
            {
                $request->request->add(['user_email' => $user_email]);
                return $next($request);
            }
        }
        return response()->json(['Message' => 'No tiene permisos'], 401);
    }
}
