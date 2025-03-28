<?php
namespace App\Services;

use App\Repository\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthService
{

    protected $authRepository;

    /**
     * Create a new class instance.
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * Function: authRegister
     * @param $request
     * @return $response
     */
    public function authRegister($request)
    {
        $request             = $request->all();
        $request['password'] = Hash::make($request['password']);

        # Register User
        return $this->authRepository->registerUser($request);
    }

    /**
     * Function: authRegister
     * @param $request
     * @return $response
     */
    public function userLogin($request)
    {
        if (! (Auth::attempt(['email' => $request['email'], 'password' => $request['password']]))) {
            return false;
        }

        $response = Http::asForm()->post(url('/oauth/token'), [
            'grant_type'    => 'password',
            'client_id'     => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'username'      => $request->email,
            'password'      => $request->password,
            'scope'         => '',
        ]);

        $authResponse = $response->json();

        if (! empty($authResponse)) {
            $authUser = Auth::user();
            // $token    = $authUser->createToken('token')->accessToken;

            return [
                'email'         => $authUser->email,
                'token_type'    => $authResponse['token_type'],
                'expires_in'    => $authResponse['expires_in'],
                'token'         => $authResponse['access_token'],
                'refresh_token' => $authResponse['refresh_token'],
            ];
        }

        return [];
    }

    /**
     * Function: userProfile
     */
    public function userProfile()
    {
        return Auth::user();
    }

    /**
     * Function: userLogout
     * @return boolean
     */
    public function userLogout()
    {
        $authUser = Auth::user();
        if ($authUser) {
            $authUser->token()->revoke();
            return true;
        }
        return false;
    }

    /**
     * Function: getAuthUser
     */
    public function getAuthUser()
    {
        return Auth::user();
    }

    /**
     * Function: refreshToken
     * @param object $request
     * @return array
     */
    public function refreshToken($request)
    {
        $response = Http::asForm()->post(url('/oauth/token'), [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id'     => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'scope'         => '',
        ]);

        $authResponse = $response->json();

        if (! empty($authResponse)) {
            return [
                'token_type'    => $authResponse['token_type'],
                'expires_in'    => $authResponse['expires_in'],
                'token'         => $authResponse['access_token'],
                'refresh_token' => $authResponse['refresh_token'],
            ];
        }

        return [];

    }
}
