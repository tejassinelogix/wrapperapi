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

                if ((isset($addRecipient['error']) || isset($addRecipient['errors'])) && (!empty($addRecipient['error']) || !empty($addRecipient['errors'])))
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
     @task_id   :: CreateQuotes Information from Transferwise
     @task_desc :: CreateQuotes Information from Transferwise Server
     @params    :: Token, profile, source, target, rateType, targetAmount, type
     @return    :: json status true / false with data and message  
    */
    public function create_quotes(Request $request)
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
                'profile' => 'required',
                'source' => 'required',
                'target' => 'required',
                'rateType' => 'required',
                'targetAmount' => 'required',
                'type' => 'required',
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
                $postData['profile'] = $request->get("profile");
                $postData['source'] = $request->get("source");
                $postData['target'] = $request->get("target");
                $postData['rateType'] = $request->get("rateType");
                $postData['targetAmount'] = $request->get("targetAmount");
                $postData['type'] = $request->get("type");

                $transferWise = new Transferwise_API($request->get("Token"));
                $addQuote = $transferWise->addQuotes($postData);

                if ((isset($addQuote['error']) || isset($addQuote['errors'])) && (!empty($addQuote['error']) || !empty($addQuote['errors'])))
                    throw new Exception('Quote is not Added...!', 422);

                $res['status'] = true;
                $res['message'] = "Quote is Added successfully..!";
                $res['data'] =  $addQuote;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: GetQuotes Information from Transferwise
     @task_desc :: GetQuotes Information from Transferwise Server
     @params    :: Token, quoteId
     @return    :: json status true / false with data and message  
    */
    public function get_quoteby_id(Request $request)
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
                'quoteId' => 'required'
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

                $postData['quoteId'] = $request->get("quoteId");
                $transferWise = new Transferwise_API($request->get("Token"));
                $getQuote = $transferWise->getQuotes($postData);

                if ((isset($getQuote['error']) || isset($getQuote['errors'])) && (!empty($getQuote['error']) || !empty($getQuote['errors'])))
                    throw new Exception('Quote ID is not Found...!', 422);

                $res['status'] = true;
                $res['message'] = "Quote Details Fetch successfully..!";
                $res['data'] =  $getQuote;
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

                if ((isset($addRecipient['error']) || isset($addRecipient['errors'])) && (!empty($addRecipient['error']) || !empty($addRecipient['errors'])))
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

    /*
     @author    :: Tejas
     @task_id   :: GetQuotePayInMethod Information from Transferwise
     @task_desc :: GetQuotePayInMethod Information from Transferwise Server
     @params    :: Token, quoteId
     @return    :: json status true / false with data and message  
    */
    public function get_quote_payinmethod(Request $request)
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
                'quoteId' => 'required'
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

                $postData['quoteId'] = $request->get("quoteId");

                $transferWise = new Transferwise_API($request->get("Token"));
                $getQuotePayMethod = $transferWise->getQuotePaymentMethods($postData);

                if ((isset($getQuotePayMethod['error']) || isset($getQuotePayMethod['errors'])) && (!empty($addRecipient['error']) || !empty($getQuotePayMethod['errors'])))
                    throw new Exception('Quote Pay-in Methods not fetch...!', 422);

                $res['status'] = true;
                $res['message'] = "Quote Pay-in Methods fetch successfully..!";
                $res['data'] =  $getQuotePayMethod;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: GetTemporaryQuote Information from Transferwise
     @task_desc :: GetTemporaryQuote Information from Transferwise Server
     @params    :: Token, quoteId
     @return    :: json status true / false with data and message  
    */
    public function get_temporary_quote(Request $request)
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
                'source' => 'required',
                'target' => 'required',
                'rateType' => 'required',
                'targetAmount' => 'required',
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
                $postData['source'] = $request->get("source");
                $postData['target'] = $request->get("target");
                $postData['rateType'] = $request->get("rateType");
                $postData['targetAmount'] = $request->get("targetAmount");

                $transferWise = new Transferwise_API($request->get("Token"));
                $getQuotePayMethod = $transferWise->getTemporaryQuote($postData);

                if ((isset($getQuotePayMethod['error']) || isset($getQuotePayMethod['errors'])) && (!empty($addRecipient['error']) || !empty($getQuotePayMethod['errors'])))
                    throw new Exception('Quote Pay-in Methods not fetch...!', 422);

                $res['status'] = true;
                $res['message'] = "Quote Pay-in Methods fetch successfully..!";
                $res['data'] =  $getQuotePayMethod;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }
}
