<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AgentAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
{
    // Check if the agent is logged in
    if (!Session::has('id')) { 
        return redirect()->route('admin.agents.login')->with('error', 'Access denied. Please log in.');
    }
    

    // // Ensure the status is properly checked
    // if ((int) Session::get('agent_status') === 0) { // Force integer comparison
    //     return redirect()->route('agent.login')->with('error', 'Your account is blocked. Contact admin.');
    // }

    return $next($request);
}

}
