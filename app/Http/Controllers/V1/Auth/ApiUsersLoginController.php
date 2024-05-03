<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Requests\V1\Auth\RefreshTokenRequest;
use App\Http\Requests\V1\Auth\ApiUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\AuthTrait;
use App\Models\ApiUser;

class ApiUsersLoginController extends Controller
{
    use AuthTrait;

    /**
     * Register api user.
     */
    public function register(ApiUserRequest $request)
    {
        $user = ApiUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $tokenObject = $this->getTokenAndRefreshToken($request->email, $request->password, 'api_users_provider');
        if ($tokenObject) {
            $data = ['api_user' => $user->basicInfo(), 'token' => $tokenObject['access_token'], 'refresh_token' => $tokenObject['refresh_token'], 'token_expire_datetime' => addSeconds($tokenObject['expires_in'])];

            return responseApi(200, $data, __('messages.success.register_success'));
        }

        return responseApi(451, [], __('messages.errors.register_failed'));
    }

    /**
     * Login api user.
     */
    public function login(ApiUserRequest $request)
    {
        if (Auth::guard('api_users_auth_session')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('api_users_auth_session')->user();
            if ($user) {
                $tokenObject = $this->getTokenAndRefreshToken($request->email, $request->password, 'api_users_provider');

                if ($tokenObject) {
                    $data = ['api_user' => $user->basicInfo(), 'token' => $tokenObject['access_token'], 'refresh_token' => $tokenObject['refresh_token'], 'token_expire_datetime' => addSeconds($tokenObject['expires_in'])];

                    return responseApi(200, $data, __('messages.success.login_success'));
                }
            }

            return responseApi(451, [], __('messages.errors.login_failed'));
        } else {
            return responseApi(451, [], __('messages.errors.wrong_credentials'));
        }
    }

    /**
     * Refresh Token.
     */
    public function refreshToken(RefreshTokenRequest $request)
    {
        $refreshedTokenObject = $this->getRefreshedToken($request->token, 'api_users_provider');
        if ($refreshedTokenObject) {
            return responseApi(200, ['token' => $refreshedTokenObject['access_token'], 'refresh_token' => $refreshedTokenObject['refresh_token'], 'token_expire_datetime' => addSeconds($refreshedTokenObject['expires_in'])], __('messages.success.refresh_token_success'));
        }

        return responseApi(451, [], __('messages.errors.refresh_token_failed'));
    }
}
