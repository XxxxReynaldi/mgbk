<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $roles = [
            'admin' => [1],
            'user'  => [1, 2],
        ];

        $roleIds = $roles[$role] ?? [];

        if (!in_array(auth()->user()->user_level, $roleIds)) {
            abort(403);
            // return redirect()->back();
        }

        return $next($request);
    }
}
