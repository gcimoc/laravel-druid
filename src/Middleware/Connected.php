<?php
namespace Genetsis\Druid\Middleware;
use Closure;
use Genetsis\Identity;
use Genetsis\Druid\Exceptions\NotConnectedException;
use Illuminate\Support\Facades\Log;

class Connected
{
    /**
     * Check if User is connected to Druid
     *
     * @param $request
     * @param Closure $next
     * @param String $to path to redirect
     * @return mixed
     * @throws NotConnectedException
     */
    public function handle($request, Closure $next, $to = null)
    {
//        if (!is_null($to)) {
//            $to = ($request->route('sponsorcode')) ? $to . '/' . $request->route('sponsorcode') : $to;
//        }

        session(['inner_redirection' => url()->current()]);

        \App::make('Druid');

        // Check user logged
        if (Identity::isConnected()) {
            Log::info('User is connected, Continue');
            return $next($request);
        }

        throw new NotConnectedException($to);
    }
}