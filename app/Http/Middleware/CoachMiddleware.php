<?php

namespace App\Http\Middleware;

use App\Constants\RolesType;
use App\Enums\ResponseMessage;
use App\Enums\StatusCode;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoachMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role_id != RolesType::RolesType['COACH_ROLE']['ID']) {
            abort(response()->json([
                'message' => ResponseMessage::FORBIDDEN->value
            ], StatusCode::FORBIDDEN->value
            ));
        }
        return $next($request);    }
}
