<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\Admin\Index\IndexRepositoryContract;

class AccessRouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     */
    protected $admin;

    public function __construct( IndexRepositoryContract $indexs ) {

        $this->admin =   $indexs;
    }


    public function handle($request, Closure $next)
    {
        if(!$this->admin->isAdmin()){

            $userRoute = $this->admin->getUserRoute($this->admin->getSessionAdminVal('id'));

            $allRoute = $this->admin->getAllRoute();

            return in_array($request->path(),array_intersect($userRoute, $allRoute)) ? $next($request) : redirect('/login');

        };

        return $next($request);
    }
}
