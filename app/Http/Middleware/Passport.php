<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

class Passport
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cookieValue = $request->cookie('access_token');
        $cookieSeparator = '@@@';
        if ($cookieValue) {
            [$accessToken,$guard] = explode($cookieSeparator,$cookieValue);
            $request->headers->set('Authorization', 'Bearer ' . $accessToken);
            Auth::setDefaultDriver($guard);
        }

        if(!$cookieValue && $request->is('oauth/token')){
            $guard = $request->input('guard');
            $data = [
                'grant_type' => 'password',
                'client_id' =>  config('auth.oauth_client.id'),
                'client_secret' => config('auth.oauth_client.secret'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'guard' => $request->input('guard'),
            ];
            $request->merge($data);
            $response = $next($request);
            if($response->getStatusCode() != 200) {
                return $response;
            }
            $content = json_decode($response->getContent(),1);
            $cookieAccessTokenValue = $content['access_token'].$cookieSeparator.$guard;
            $cookie = new Cookie(config('auth.oauth_client.cookie_name'),$cookieAccessTokenValue,time()+$content['expires_in']-10);
            $response->setContent([])->withCookie($cookie);
            return $response;
        }
        return $next($request);
    }
}
