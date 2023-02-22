<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public function sendResponse($data, $message="request completed successfully", $code = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'message' => $message,
            'code' => $code,
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    public  function sendError($error, $code, $message="The request was executed with an error"): \Illuminate\Http\JsonResponse
    {
        $response = [
            'error' => $error,
            'code' => $code,
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }
}
