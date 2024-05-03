<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Requests\V1\Auth\RefreshTokenRequest;
use App\Http\Requests\V1\Auth\AppUserRequest;
use App\Http\Controllers\Controller;
use App\Models\ConnectionHistory;
use App\Models\Email;
use App\Models\LoginAttempt;
use App\Notifications\UserActivateAccountNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Traits\AuthTrait;
use App\Models\User;

class AppUsersLoginController extends Controller
{
    use AuthTrait;

    /**
     * Register app user.
     */
    public function register(AppUserRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user) {
            $tokenObject = $this->getTokenAndRefreshToken($request->name, $request->password, 'app_users_provider');


            if ($tokenObject) {

                //Check if user has verified his email or not , if not send him a new email with new token
                if (!$user->email_verified_at) {

                    // check if he is loging in with the url sent to his email
                    if ($request->email_verification_token) {
                        // check if the request token = user token within the database
                        if ($request->email_verification_token == $user->email_verification_token) {
                            $user->update([
                                'email_verified_at' => Carbon::now()
                            ]);
                        } else {
                            // resend him new email with new token
                            $email_verificdation_Token = bcrypt($user->id);

                            $user->update([
                                'email_verification_token' => $email_verificdation_Token,
                            ]);

                            $email = Email::where('type', 'user_activate_account')->first();
                            if ($email) {
                                $user->notify(new UserActivateAccountNotification($user, $email, null, $email_verificdation_Token));
                            }

                            Auth::guard('app_users_auth_session')->logout();

                            return responseApi(422, [], __('messages.errors.verification_email_sent'));
                        }
                    } else {
                        Auth::guard('app_users_auth_session')->logout();
                        return responseApi(422, [], __('messages.errors.email_not_verified'));
                    }
                }


                $data = ['user' => $user->basicInfo(), 'token' => $tokenObject['access_token'], 'refresh_token' => $tokenObject['refresh_token'], 'token_expire_datetime' => addSeconds($tokenObject['expires_in'])];

                return responseApi(200, $data, __('messages.success.register_success'));
            } else {
                $user->delete();
            }
        }

        return responseApi(401, [], __('messages.errors.register_failed'));
    }


    public function login(AppUserRequest $request)
    {

        // Attempt to log in
        $login = Auth::guard('app_users_auth_session')->attempt($request->validated());

        if ($login) {
            // Login successful
            $user = Auth::guard('app_users_auth_session')->user();
            if ($user) {

                //Check if user has verified his email or not , if not send him a new email with new token
                if (!$user->email_verified_at) {

                    // check if he is loging in with the url sent to his email
                    if ($request->email_verification_token) {
                        // check if the request token = user token within the database
                        if ($request->email_verification_token == $user->email_verification_token) {
                            $user->update([
                                'email_verified_at' => Carbon::now()
                            ]);
                        } else {
                            // resend him new email with new token
                            $email_verificdation_Token = bcrypt($user->id);

                            $user->update([
                                'email_verification_token' => $email_verificdation_Token,
                            ]);

                            $email = Email::where('type', 'user_activate_account')->first();
                            if ($email) {
                                $user->notify(new UserActivateAccountNotification($user, $email, null, $email_verificdation_Token));
                            }

                            Auth::guard('app_users_auth_session')->logout();

                            return responseApi(422, [], __('messages.errors.verification_email_sent'));
                        }
                    } else {
                        Auth::guard('app_users_auth_session')->logout();
                        return responseApi(422, [], __('messages.errors.email_not_verified'));
                    }
                }

                $userName = isset($request->name) ? $request->name : $request->email;

                $tokenObject = $this->getTokenAndRefreshToken($userName, $request->password, 'app_users_provider');

                if ($tokenObject) {
                    $data = [
                        'user' => $user->basicInfo(),
                        'token' => $tokenObject['access_token'],
                        'refresh_token' => $tokenObject['refresh_token'],
                        'token_expire_datetime' => addSeconds($tokenObject['expires_in']),
                    ];

                    return responseApi(200, $data, __('messages.success.login_success'));
                }
            }

            Auth::guard('app_users_auth_session')->logout();
            return responseApi(401, [], __('messages.errors.login_failed'));
        } else {
            // Login failed
            return responseApi(401, [], __('messages.errors.wrong_credentials'));
        }
    }


    /**
     * Refresh Token.
     */
    public function refreshToken(RefreshTokenRequest $request)
    {
        $refreshedTokenObject = $this->getRefreshedToken($request->token, 'app_users_provider');

        if ($refreshedTokenObject) {
            return responseApi(200, ['token' => $refreshedTokenObject['access_token'], 'refresh_token' => $refreshedTokenObject['refresh_token'], 'token_expire_datetime' => addSeconds($refreshedTokenObject['expires_in'])], __('messages.success.refresh_token_success'));
        }

        return responseApi(401, [], __('messages.errors.refresh_token_failed'));
    }


    public function loginAttemptBlocked($request)
    {
        $LoginAttempt = LoginAttempt::where('login', $request->login)->first();

        if ($LoginAttempt) {
            if ($LoginAttempt->attempts >= 3) {

                $lastAttemptTime = Carbon::parse($LoginAttempt->date);
                $currentTime = Carbon::now();
                $minutesDifference = $currentTime->diffInMinutes($lastAttemptTime);
                // Block the user if the last login attempt was within the last n minutes
                if ($minutesDifference <= config('common.login_attempts_time')) {
                    return true;
                } else {
                    //update attempt count if < 3
                    $LoginAttempt->update([
                        'attempts' => 1,
                        'date' => Carbon::now(),
                    ]);
                }
            } else {
                //update attempt count if < 3
                $LoginAttempt->update([
                    'attempts' => $LoginAttempt->attempts + 1,
                    'date' => Carbon::now(),
                ]);
            }
        } else {
            $LoginAttempt = LoginAttempt::create([
                'login' => $request->login,
                'attempts' => 1,
                'date' => Carbon::now(),
            ]);
        }

        return false;
    }
}
