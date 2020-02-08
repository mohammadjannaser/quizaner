<?php

namespace App\Http\Controllers;

use App\Model\EnrolledUser;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class EnrolledUserController extends Controller
{
    
    public function enrollUserForTest(Request  $request){


        $testId;
        $userId;

        // Get test id from request if test id is null so return nothing
        if(!empty($request->test_id)){
            $testId = $request->test_id;
        
        }else{

            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' =>'',
                'message' => ' test Id can not be null'
            ],Response::HTTP_NOT_FOUND);
        }


        // Check user id from request if user id snull so return nothing
        if(!empty($request->user_id)){
            $userId = $request->user_id;

        }else{
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' =>'',
                'message' => ' user Id can not be null'
            ],Response::HTTP_NOT_FOUND);
        }

        // Check weather user has enrolled for particular test or not
        $isEnrolled = EnrolledUser::where('user_id',$userId)
                ->where('test_id',$testId)
                ->first();


        // If user not enrolled so enroll user 
        if(empty($isEnrolled)){
          
            $enroll = new EnrolledUser;
            $enroll->user_id = $userId;
            $enroll->test_id = $testId;
            if($enroll->save()){
                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' =>'',
                    'message' => 'You Successfully Enrolled For this test'
                ],Response::HTTP_OK);
            }

        }else{
            return response([
                'http_response' => Response::HTTP_OK,
                'data' =>'',
                'message' => 'You already enrolled for this test :)'
            ],Response::HTTP_OK);
        }


    }
}
