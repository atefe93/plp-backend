<?php

namespace App\Http\Middleware;

use App\Repositories\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserBlock
{

    public function handle(Request $request, Closure $next)
    {
        if (!resolve(UserRepository::class)->isBlock()) {
            return $next($request);
        }
        return response()->json([
            'message' => 'you are blocked'
        ], Response::HTTP_FORBIDDEN);
    }
}
