<?php

namespace App\Http\Controllers;

use App\Model\Follower;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use DB;

class FollowerController extends Controller
{


    public function followUser(Request  $request){

        // Here we need two user 
        // 1 user1_id which is the first user (follower) account user which I will get it from the request
        // 2 user2_id which is the second user or (Following) which i will get it from request..
        $accountId;
        $userId;

        // Get account id from request if account id is null so return nothing
        if(!empty($request->account_id)){
            $accountId = $request->account_id;
        
        }else{

            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' =>'',
                'message' => ' Account Id can not be null'
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

        // Check weather user has followed particular account or not
        $isFollowed = Follower::where('user1_id',$accountId)
                ->where('user2_id',$userId)
                ->first();


        // If user has followed so do unfollow user 
        if(!empty($isFollowed)){
            $check = DB::table('followers')->where('id', '=', $isFollowed->id)->delete();
            if($check>0){
                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' =>'',
                    'message' => 'User became unfollowed'
                ],Response::HTTP_OK);
            }

        }else{
            // If user has not followed so do follow user
            $follow = new Follower;
            $follow->user1_id = $accountId;
            $follow->user2_id = $userId;
            if($follow->save()){
                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' =>'',
                    'message' => 'User became followed'
                ],Response::HTTP_OK);
            }

        }


    }
    
}
