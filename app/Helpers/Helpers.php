<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


if (!function_exists('set_active')) {
    function set_active($uri)
    {
        if (request()->segment(2) == str_replace("/", "", $uri)) {
            return 'active';
        }
    }
}

if (!function_exists('is_active')) {
    function is_active($uri)
    {
        if (is_array($uri)) {
            foreach ($uri as $u) {
                if (Route::is($u)) {
                    return 'active';
                }
            }
        } else {
            if (Route::is($uri)) {
                return 'active';
            }
        }
    }
}

if (!function_exists('is_show')) {
    function is_show($uri)
    {
        if (is_array($uri)) {
            foreach ($uri as $u) {
                if (Route::is($u)) {
                    return 'show';
                }
            }
        } else {
            if (Route::is($uri)) {
                return 'show';
            }
        }
    }
}

function setting_web()
{
    $setting = DB::table('setting_apps')->first();
    return $setting;
}
