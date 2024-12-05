<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class SendEmailThrottleMiddleware
{
    protected RateLimiter $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public function handle($request, Closure $next, $maxAttempts = 30, $maxEmailAttempts = 10, $decayMinutes = 1)
    {
        $ipKey = $request->ip();
        $emailKey = 'email:' . $request->input('email');

        if ($this->limiter->tooManyAttempts($ipKey, $maxAttempts)) {
            return response('Too Many Attempts.', Response::HTTP_TOO_MANY_REQUESTS);
        }

        if ($this->limiter->tooManyAttempts($emailKey, $maxEmailAttempts)) {
            return response('Too Many Attempts for this email.', Response::HTTP_TOO_MANY_REQUESTS);
        }

        $this->limiter->hit($ipKey, $decayMinutes * 60);
        $this->limiter->hit($emailKey, $decayMinutes * 60);

        return $next($request);
    }
}
