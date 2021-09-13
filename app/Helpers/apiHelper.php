<?php
namespace App\Helpers;

use Response;
use Illuminate\Support\Arr;
class apiHelper
{
    public static function okResponse($data = null)
    {
        $status_code = isset($data) ? 200 : 205;
        return response()->json(['status'=> 'success','data' => $data],$status_code);
    }

    public static function failResponse($message,$code = 422)
    {
        if(!is_array($message))
            $message = (array)$message;
        return response()->json(['status'=> 'fail','errors' => self::formatValidationMessages($message)],$code);
    }

    public static function formatValidationMessages($errors)
    {

        return Arr::flatten($errors);
    }
    public static function sendResponse($result, $message,  $code = 200, $errorCode = 0)
    {
        return Response::json([
            'status' => $code,
            'errorCode' => $errorCode,
            'data' => $result,
            'message' => $message
        ], $code);
    }



}
