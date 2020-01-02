<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
class IsAgent {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $user = $request->user();

        if ($user && $user->isAgent())
        {
            return $next($request);
        }
        dd($user);
        return new RedirectResponse(url('/auth/login'));
	}

}
