<?php

namespace App\Traits;

trait HttpResponses{
  public function success_message($data, $message = null, $code = 200){
    return response()->json([
      'status' => 'Request was successful',
      'message' => $message,
      'data' => $data
    ], $code);
  }

  public function error_messsage($data, $message = null, $code = 500){
    return response()->json([
      'status' => 'Error has occured',
      'message' => $message,
      'data' => $data
    ], $code);
  }
}