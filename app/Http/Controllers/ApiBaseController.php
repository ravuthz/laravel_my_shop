<?php

namespace App\Http\Controllers;

abstract class ApiBaseController extends Controller {

    public function sendJson($data, $message = '', $status = 200) {
        return response()->json([
            'data' => $data,
            'errors' => null,
            'message' => $message
        ], $status);
    }

    public function sendError($error, $message = '', $status = 500) {
        return response()->json([
            'data' => null,
            'errors' => $error,
            'message' => $message
        ], $status);
    }

}
