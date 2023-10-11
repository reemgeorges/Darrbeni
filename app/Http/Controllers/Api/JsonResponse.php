<?php

namespace App\Http\Controllers\Api;
// use Illuminate\Http\JsonResponse as HttpJsonResponse;
use Illuminate\Support\Facades\Validator;
Trait JsonResponse{

    public function successResponse($message = null, $data = null, $code = 200)
{
    return response()->json([
        'status' => true,
        'message' => $message,
        'data' => $data ?: (object) [],
        'code' => $code
    ]);
}

    public function errorResponse($message, $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'code' => $code,
        ]);
    }

    public function notFoundResponse($message = 'Resource Not found',$code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'code' => $code,
        ]);
    }


    protected function handleException(\Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Database\QueryException) {
            // Handle database query exceptions
            return $this->errorResponse('An error occurred while executing the database query.', 500);
        } elseif ($exception instanceof \Exception) {
            // Handle other general exceptions
            return $this->errorResponse('An error occurred.', 500);
        }

        // If the exception is not handled above, rethrow it
        throw $exception;
    }

}
