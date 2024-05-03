<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\EditPasswordRequest;
use App\Http\Requests\V1\Auth\ForgetPasswordRequest;
use App\Models\Email;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AppUsersForgetPasswordController extends Controller
{

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)
        ->first();

        if ($user) {

            $token = bin2hex(random_bytes(128)) . time();
            $minutes_to_add = config('common.minutes_to_add_to_activation_token');
            $token_expire_datetime = date('Y-m-d H:i:s', strtotime('+ ' . $minutes_to_add . ' minutes', time()));

            $user->update([
                'access_token' => $token,
                'token_expire_datetime' => $token_expire_datetime,
            ]);

            $email = Email::where('type', 'forgot_password')->firstOrFail();
            $user->notify(new ResetPasswordNotification($user, $email, $token));

            return responseApi(200, [
                'access_token' => $user->access_token,
                'token_expire_datetime' => $user->token_expire_datetime,
                'membership' => $user,
            ], __('messages.errors.forgot_password'));
        }

        return responseApi(404, [], __('messages.errors.wrong_credentials'));
    }

    public function checkForgetPasswordToken($token)
    {
        $user = User::where('access_token', $token)->first();

        if ($user) {

            $token_expire_datetime = Carbon::parse($user->token_expire_datetime);
            if (Carbon::now()->gt($token_expire_datetime)) {
                // Token has expired
                return responseApi(401, __('messages.errors.token_expired'));
            }

            $data = [
                'user' => $user->basicInfo(),
                'token' => $user->access_token,
                'token_expire_datetime' => $user->token_expire_datetime,
            ];


            return responseApi(200, $data);
        }

        return responseApi(404, __('messages.errors.wrong_token'));
    }

    public function editPassword(EditPasswordRequest $request, $token)
    {
        $user = User::where('access_token', $token)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return responseApi(422, __('messages.errors.incorrect_new_password'));
            }

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return responseApi(200, __('messages.success.password_updated'));
        }

        return responseApi(404, __('messages.errors.incorrect_id'));
    }

}
