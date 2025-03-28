<?php
namespace App\Http\Controllers\Auth;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLogin;
use App\Http\Requests\AuthRegister;
use App\Http\Requests\RefreshTokenRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Function: register
     * @param App\Http\Requests\AuthRegister $request
     * @return Illuminate\Http\JsonResponse
     */
    public function register(AuthRegister $request)
    {
        try {
            $response = $this->authService->authRegister($request);

            if ($response) {
                return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $response, statusCode: self::SUCCESS);
            }
            return ApiResponse::error(status: self::ERROR_STATUS, message: self::FAILED_MESSAGE, statusCode: self::ERROR);

        } catch (Exception $e) {
            Log::error('Exception occured while registering user' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    /**
     * Function: login
     * @param App\Http\Requests\AuthLogin $request
     * @return Illuminate\Http\JsonResponse
     */
    public function login(AuthLogin $request)
    {
        try {
            $loginResponse = $this->authService->userLogin($request);

            if (! $loginResponse) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::INVALID_CREDENTIALS, statusCode: self::ERROR);
            }

            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $loginResponse, statusCode: self::SUCCESS);

        } catch (Exception $e) {
            Log::error('Exception occured while logging user' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    /**
     * Function: userProfile
     * @return Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        try {
            $authUser = $this->authService->userProfile();

            if (! $authUser) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::USER_NOT_FOUND, statusCode: self::ERROR);
            }

            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $authUser, statusCode: self::SUCCESS);

        } catch (Exception $e) {
            Log::error('Exception occured while fetching user' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    /**
     * Function: logout
     * @param NA
     * @return Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $response = $this->authService->userLogout();

            if (! $response) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::USER_NOT_FOUND, statusCode: self::ERROR);
            }

            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::USER_LOGGED_OUT, statusCode: self::SUCCESS);

        } catch (Exception $e) {
            Log::error('Exception occured while logout the user' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }

    /**
     * Function: refreshToken
     * @param Illuminate\Http\Requests\RefreshTokenRequest
     * @return Illuminate\Http\JsonResponse
     */
    public function refreshToken(RefreshTokenRequest $request)
    {
        try {
            $authResponse = $this->authService->refreshToken($request);

            if (! $authResponse) {
                return ApiResponse::error(status: self::ERROR_STATUS, message: self::USER_NOT_FOUND, statusCode: self::ERROR);
            }

            return ApiResponse::success(status: self::SUCCESS_STATUS, message: self::SUCCESS_MESSAGE, data: $authResponse, statusCode: self::SUCCESS);

        } catch (Exception $e) {
            Log::error('Exception occured while refreshing the tokens' . $e->getMessage());
            return ApiResponse::success(status: self::ERROR_STATUS, message: self::EXCEPTION_MESSAGE, statusCode: self::ERROR);
        }
    }
}
