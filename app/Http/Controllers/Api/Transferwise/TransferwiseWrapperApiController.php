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

                if (isset($getProfile['error']) || !empty($getProfile['error']))
                    throw new Exception('Profile Id not found...!', 422);

                $res['status'] = true;
                $res['message'] = "Profile get successfully..!";
                $res['data'] =  $getProfile;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: CreateRecipientAccounts Information from Transferwise
     @task_desc :: CreateRecipientAccounts Information from Transferwise Server
     @params    :: Token, currency, 
     @return    :: json status true / false with data and message  
    */
    public function create_recipient_accounts(Request $request)
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
                ],
                'currency' => 'required',
                'type' => 'required',
                'profile' => 'required',
                'ownedByCustomer' => 'required',
                'accountHolderName' => 'required',
                'legalType' => 'required',
                'sortCode' => 'required',
                'accountNumber' => 'required',
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

                $postData['currency'] = $request->get("currency");
                $postData['type'] = $request->get("type");
                $postData['profile'] = $request->get("profile");
                $postData['ownedByCustomer'] = $request->get("ownedByCustomer");
                $postData['accountHolderName'] = $request->get("accountHolderName");
                $postData['details']['legalType'] = $request->get("legalType");
                $postData['details']['sortCode'] = $request->get("sortCode");
                $postData['details']['accountNumber'] = $request->get("accountNumber");

                $transferWise = new Transferwise_API($request->get("Token"));
                $addRecipient = $transferWise->addRecipientAccounts($postData);

                if (isset($addRecipient['error']) || !empty($addRecipient['error']))
                    throw new Exception('Recipient Account not Added...!', 422);

                $res['status'] = true;
                $res['message'] = "Recipient Account Added successfully..!";
                $res['data'] =  $addRecipient;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }
}
