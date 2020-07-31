<?php

namespace App\Http\Controllers\Api\ShipsGo;

use Exception;
use App\Rules\MatchAuthCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ShipsGo\ShipsGo_API;

class ShipsGoWrapperApiController extends Controller
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
     @task_id   :: ShippingLineList details fetch from ShipsGo
     @task_desc :: ShippingLineList details fetch from ShipsGo Server
     @params    :: AuthCode
     @return    :: json status true / false with data and message  
    */
    public function get_shippingline_list(Request $request)
    {
        $res = Config('response_format.RES_RESULT');
        try {
            $validate = Validator::make($request->all(), [
                'authCode' => [
                    'required', new MatchAuthCode,
                    // 'in:' . Config('response_format.AuthCode') . '', // Contains Predefined AuthCode
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
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
                $shipsGo = new ShipsGo_API($request->get("authCode"));
                $getShipLine = $shipsGo->GetShippingLineList();

                if (isset($getShipLine['Message']) || !empty($getShipLine['Message']))
                    throw new Exception('ShippingLine List not found...!', 422);

                $res['status'] = true;
                $res['message'] = "ShippingLine List get successfully..!";
                $res['data'] =  $getShipLine;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: GetContainer Information fetch from ShipsGo
     @task_desc :: GetContainer Information fetch from ShipsGo Server
     @params    :: AuthCode, RequestId
     @return    :: json status true / false with data and message  
    */
    public function get_container_info(Request $request)
    {
        $res = Config('response_format.RES_RESULT');
        try {
            $validate = Validator::make($request->all(), [
                'authCode' => [
                    'required', new MatchAuthCode,
                    // 'in:' . Config('response_format.AuthCode') . '', // Contains Predefined AuthCode
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'requestId' => 'required'
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
                $shipsGo = new ShipsGo_API($request->get("authCode"));
                $getContainer = $shipsGo->GetContainerInfo($request->get("requestId"));

                if (isset($getContainer['Message']) || !empty($getContainer['Message']))
                    throw new Exception('Container Request Id not found...!', 422);

                $res['status'] = true;
                $res['message'] = "Container Information get successfully..!";
                $res['data'] =  $getContainer;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: PostContainer Information fetch from ShipsGo
     @task_desc :: PostContainer Information fetch from ShipsGo Server
     @params    :: AuthCode, RequestId, ShippingLine
     @return    :: json status true / false with data and message  
    */
    public function post_container_info(Request $request)
    {
        $res = Config('response_format.RES_RESULT');
        try {
            $validate = Validator::make($request->all(), [
                'authCode' => [
                    'required', new MatchAuthCode,
                    // 'in:' . Config('response_format.AuthCode') . '', // Contains Predefined AuthCode
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'containerNumber' => [
                    'required',
                    'string',
                    'min:11',             // must be at least 8 characters in length
                    'regex:/[A-Z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'shippingLine' => [
                    'required',
                    'string'
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
                $shipsGo = new ShipsGo_API($request->get("authCode"));
                $postContainer = $shipsGo->PostContainerInfo($request->get("containerNumber"), $request->get("shippingLine"));

                if (isset($postContainer['Message']) || !empty($postContainer['Message']))
                    throw new Exception('Container Information not inserted...!, Please try again..!', 422);

                $res['status'] = true;
                $res['message'] = "Container Information insert successfully..!";
                $res['data'] =  $postContainer;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: PostCustomContainer Information fetch from ShipsGo
     @task_desc :: PostCustomContainer Information fetch from ShipsGo Server
     @params    :: AuthCode, RequestId, ShippingLine, EmailAdress, referenceNo (Optional)
     @return    :: json status true / false with data and message  
    */
    public function post_customcontainer_info(Request $request)
    {
        $res = Config('response_format.RES_RESULT');
        try {
            $validate = Validator::make($request->all(), [
                'authCode' => [
                    'required', new MatchAuthCode,
                    // 'in:' . Config('response_format.AuthCode') . '', // Contains Predefined AuthCode
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'containerNumber' => [
                    'required',
                    'string',
                    'min:11',             // must be at least 8 characters in length
                    'regex:/[A-Z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'shippingLine' => [
                    'required',
                    'string'
                ],
                'emailAddress' => 'required|email'
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
                $shipsGo = new ShipsGo_API($request->get("authCode"));
                if ($request->has('emailAddress') && $request->has('referenceNo')) {
                    $postCustomContainer = $shipsGo->PostContainerInfo($request->get("containerNumber"), $request->get("shippingLine"), $request->get("emailAddress"), $request->get("referenceNo"));
                } else {
                    $postCustomContainer = $shipsGo->PostContainerInfo($request->get("containerNumber"), $request->get("shippingLine"), $request->get("emailAddress"));
                }

                if (isset($postCustomContainer['Message']) || !empty($postCustomContainer['Message']))
                    throw new Exception('Custom Container Information not inserted...!, Please try again..!', 422);

                $res['status'] = true;
                $res['message'] = "Custom Container Information insert successfully..!";
                $res['data'] =  $postCustomContainer;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: PostContainer Information With BL fetch from ShipsGo
     @task_desc :: PostContainer Information With BL fetch from ShipsGo Server
     @params    :: AuthCode, Container Number, ShippingLine, Containers Count, BL Containers Ref
     @return    :: json status true / false with data and message  
    */
    public function post_containerinfo_bl(Request $request)
    {
        $res = Config('response_format.RES_RESULT');
        try {
            $validate = Validator::make($request->all(), [
                'authCode' => [
                    'required', new MatchAuthCode,
                    // 'in:' . Config('response_format.AuthCode') . '', // Contains Predefined AuthCode
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'containerNumber' => [
                    'required',
                    'string',
                    'min:11',             // must be at least 8 characters in length
                    'regex:/[A-Z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'shippingLine' => [
                    'required',
                    'string'
                ],
                'containersCount' => [
                    'required',
                    'integer',
                    'gt:0'
                ],
                'blContainersRef' => [
                    'required',
                    'string'
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
                $shipsGo = new ShipsGo_API($request->get("authCode"));
                $postContainerWithBI = $shipsGo->PostContainerInfoWithBl($request->get("containerNumber"), [$request->get("blContainersRef"), $request->get("containersCount")], $request->get("shippingLine"));

                if (isset($postContainerWithBI['Message']) || !empty($postContainerWithBI['Message']))
                    throw new Exception('Container Information with BI not inserted...!, Please try again..!', 422);

                $res['status'] = true;
                $res['message'] = "Container Information with BI insert successfully..!";
                $res['data'] =  $postContainerWithBI;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: Post Custom Container Information With BI fetch from ShipsGo
     @task_desc :: Post Custom Container Information With BI fetch from ShipsGo Server
     @params    :: AuthCode, Container Number, ShippingLine, Email, Reference Number (Optional), Containers Count, BI Containers Ref
     @return    :: json status true / false with data and message  
    */
    public function post_customcontainerinfo_bl(Request $request)
    {
        $res = Config('response_format.RES_RESULT');
        try {
            $validate = Validator::make($request->all(), [
                'authCode' => [
                    'required', new MatchAuthCode,
                    // 'in:' . Config('response_format.AuthCode') . '', // Contains Predefined AuthCode
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'containerNumber' => [
                    'required',
                    'string',
                    'min:11',             // must be at least 8 characters in length
                    'regex:/[A-Z]/',      // must contain at least one lowercase letter
                    'regex:/[0-9]/'      // must contain at least one digit
                ],
                'shippingLine' => [
                    'required',
                    'string'
                ],
                'emailAddress' => 'required|email',
                'containersCount' => [
                    'required',
                    'integer',
                    'gt:0'
                ],
                'blContainersRef' => [
                    'required',
                    'string'
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

                $shipsGo = new ShipsGo_API($request->get("authCode"));
                if ($request->has('referenceNo')) {
                    $postCustomContainerWithBI = $shipsGo->PostContainerInfoWithBl($request->get("containerNumber"), [$request->get("blContainersRef"), $request->get("containersCount")], $request->get("shippingLine"), $request->get("emailAddress"), $request->get("referenceNo"));
                } else {
                    $postCustomContainerWithBI = $shipsGo->PostContainerInfoWithBl($request->get("containerNumber"), [$request->get("blContainersRef"), $request->get("containersCount")], $request->get("shippingLine"), $request->get("emailAddress"));
                }

                if (isset($postCustomContainerWithBI['Message']) || !empty($postCustomContainerWithBI['Message']))
                    throw new Exception('Custom Container Information with BI not inserted...!, Please try again..!', 422);

                $res['status'] = true;
                $res['message'] = "Custom Container Information with BI insert successfully..!";
                $res['data'] =  $postCustomContainerWithBI;
                return response()->json($res);
            }
        } catch (Exception $ex) {
            $res['message'] = $ex->getMessage();
            return response()->json($res, 422);
        }
    }
}
