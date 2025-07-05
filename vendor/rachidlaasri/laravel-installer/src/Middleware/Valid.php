<?php
namespace RachidLaasri\LaravelInstaller\Middleware;
use Closure;
use Auth;
class Valid
{
	public function handle($request, Closure $next)
	{
		return $next($request);
	}
}
