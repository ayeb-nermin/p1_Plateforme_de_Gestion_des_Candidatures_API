<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

if (!function_exists('responseApi')) {
    /**
     * Return standard response api.
     */
    function responseApi($status, $data = [], $msg = 'OK', $errors = [])
    {
        $statusBoolean = ((200 == $status) || (201 == $status)) ? true : false;

        $response = [
            'base_url' => config('app.url'),
            'status' => $statusBoolean,
            'message' => $msg,
        ];
        $response['status_code'] = $status;

        if (!empty($data)) {
            $response['data'] = $data;
        }
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
        logResponse($status, json_encode($response));

        return response()->json($response, $status);
    }
}

if (!function_exists('logResponse')) {
    /**
     * Write log api response.
     */
    function logResponse($status, $response)
    {
        $routeCurrentRoute = Route::getCurrentRoute();
        $methodName = is_null($routeCurrentRoute) ?? $routeCurrentRoute->getActionMethod();
        $msg = '** "' . $methodName . '" started';
        $msg .= ' **' . PHP_EOL;
        $msg .= '    #Uri : "' . request()->path() . '"' . PHP_EOL;
        $msg .= '    #Method : "' . request()->method() . '"' . PHP_EOL;
        // Log header without bearer token
        $allHeaders = getallheaders();
        if ($allHeaders) {
            unset($allHeaders['Authorization']);
            $msg .= '    #Headers : ' . json_encode($allHeaders) . PHP_EOL;
        }
        // Log data without password
        $data = request()->all();
        if ($data) {
            unset($data['password']);
            $msg .= '    #Data : ' . json_encode($data) . PHP_EOL;
        }
        $wsLogs = getSession($methodName);
        $msg .= $wsLogs;
        $wsLogs = clearSession($methodName);
        $msg .= '    #Status : "' . $status . '"' . PHP_EOL;
        if (200 == $status || 404 == $status || 201 == $status) {
            $msg .= '    #Response :' . $response;
            logging($msg, "info");
        } elseif (422 == $status || 500 == $status || 401 == $response) {
            $msg .= '   #Response :' . $response;
            logging($msg, "error");
        } else {
            $msg .= '   #Response :' . $response;
            logging($msg, "alert");
        }
    }
}

if (!function_exists('setSession')) {
    function setSession($session_name, $data)
    {
        session()->put(
            $session_name,
            $data
        );
        session()->save();
    }
}

if (!function_exists('getSession')) {
    function getSession($session_name)
    {
        return session()->get($session_name);
    }
}

if (!function_exists('clearSession')) {
    function clearSession($session_name)
    {
        Session::forget($session_name);
        Session::flush();
    }
}

if (!function_exists('addSeconds')) {
    /**
     * add seconds to current date.
     */
    function addSeconds($seconds)
    {
        $now = Carbon::now();
        return $now->addSeconds($seconds);
    }
}

if (!function_exists('locale')) {
    function locale()
    {
        $locale = app()->getLocale();

        return $locale;
    }
}

if (!function_exists('logging')) {
    /**
     * Log a message
     *
     * @param string $message
     * @param string $type Accepts the laravel types (default INFO)
     */
    function logging($message, $type = 'info')
    {
        Log::{$type}(Carbon::now() . ' : ' . $message);
    }
}
