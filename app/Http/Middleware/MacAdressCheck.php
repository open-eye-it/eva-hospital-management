<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\MacAddress;

class MacAdressCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // get ip address and fix from all pc which we want to connect
        // Request::ip();

        // $mac = exec('getmac');
        // $mac = str_replace(' Media disconnected', '', $mac);
        // $mac = trim($mac);

        // $data = MacAddress::where('ma_address', $mac)->get()->first();
        // if (empty($data)) {
        //     return redirect()->route('access-denied');
        // }
        return $next($request);
    }
}
