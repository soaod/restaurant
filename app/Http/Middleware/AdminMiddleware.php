<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        if ( $request->acceptsJson() ) {
            if ( $request->user("api")->role->id != 1 ) {
                return \response()->json([
                    'status' => "error",
                    'message' => "Unauthorized Access"
                ]);
            }
        } else {
            abort(403, "Unauthorized Access");
        }
        return $next($request);
    }
}
