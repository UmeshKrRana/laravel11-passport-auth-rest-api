<?php
namespace App\Helper;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Function: success
     * @param status
     * @param message
     * @param data
     * @param statusCode
     * @return Illuminate\Http\JsonResponse
     */
    public static function success($status = 'success', $message = null, $data = [], $statusCode = 200)
    {
        return response()->json(
            [
                'status'  => $status,
                'message' => $message,
                'data'    => $data,
            ], $statusCode
        );
    }

    /**
     * Function: error
     * @param status
     * @param message
     * @param statusCode
     * @return Illuminate\Http\JsonResponse
     */
    public static function error($status = 'error', $message = null, $statusCode = 500)
    {
        return response()->json(
            [
                'status'  => $status,
                'message' => $message,
            ], $statusCode
        );
    }
}
