<?php

namespace App\Http\Middleware;

use App;
use App\Models\Role;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('DB_DATABASE')) {

            if (auth()->check()) {
                // if (!auth()->user()->hasAnyRole(Role::all()) && auth()->user()->language) {
                if (auth()->user()->language) {
                    $language = auth()->user()->language;
                    // Log::error($language);
                } else {
                    $language = Setting::first()->language;
                    // Log::error($language);
                }
            } elseif (session()->has('locale') && session()->has('direction')) {
                // dd(session()->get('locale'));
                $language = session()->get('locale');
                // Log::error($language);
            } else {
                $language = Setting::first()->language;
                // Log::error($language);
            }
            if ($language) {
                // dd($language);
                // Log::error($language);
                $direction = \App\Models\Language::where('name', $language)->first()->direction;
                App::setLocale($language);
                session()->put('locale', $language);
                session()->put('direction', $direction);
            }
        }

        return $next($request);
    }
}
