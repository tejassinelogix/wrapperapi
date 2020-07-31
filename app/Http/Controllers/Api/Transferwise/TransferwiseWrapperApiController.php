<?php

namespace App\Http\Controllers\Api\Transferwise;

use Exception;
use App\Rules\MatchAuthCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Transferwise\Transferwise_API;

class TransferwiseWrapperApiController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /*
     @author    :: Tejas
     @task_id   :: GetProfile Information fetch from Transferwise
     @task_desc :: GetProfile Information fetch from Transferwise Server
     @params    :: Token
     @return    :: json status true / false with data and message  
    */
    public function get_profile_info(Request $request)
    {
        $res = Config('response_format.RES_RESULT');
        try {
            $validate = Validator::make($request->all(), [
                'Token' => [
                    'required', new MatchAuthCode,
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ]
            ]);

            if ($validate->fails()) { // fails
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validate->messages(),
                        'data' => []
                    ],
                    422
                );
            } else { // success

                $transferWise = new Transferwise_API($request->get("Token"));
                $getProfile = $transferWise->getProfileData();
                dd($getProfile);

                if (isset($getProfile['Message']) || !empty($getProfile['Message']))
                    throw new Exception('Container Request Id not found...!', 422);

                $res['status'] = true;
                $res['message'] = "Container Information get successfully..!";
                $res['data'] =  $getProfile;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }
}
