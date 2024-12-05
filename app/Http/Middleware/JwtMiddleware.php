<?php

namespace App\Http\Middleware;

use App\Enums\StatusCode;
use App\Exceptions\TokenExceptions\TokenExpiredException as CustomTokenExpiredException;
use App\Exceptions\TokenExceptions\TokenInvalidException;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    use ResponseTrait;

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws CustomTokenExpiredException
     * @throws TokenInvalidException
     * @throws AuthenticationException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return $this->errorResponse('user not found', StatusCode::NOT_FOUND->value);
            }
        } catch (TokenExpiredException $e) {
            throw new CustomTokenExpiredException();
        } catch (JWTException $e) {
            throw new TokenInvalidException();
        }

        return $next($request);
    }
}
