<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use DB;

class UserController extends Controller
{

    

    /*****
     * For sign in there is three situations
     * 
     * 
     */

    public function login(Request $request){


        if(!empty($request->phone)){

            $user = DB::table('users')->where('phone',$request->phone)->first();

            if($user !==null){

                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' => $user,
                    'message' => 'data successfully selected'
                ],Response::HTTP_OK);

            }else{

                $newUser = new User;
                $newUser->phone = $request->phone;
                $newUser->google_id = $request->google_id;
                $newUser->facebook_id = $request->facebook_id;
                
                if($newUser->save()){
                    return response([
                        'http_response' => Response::HTTP_OK,
                        'data' => $newUser,
                        'message' => 'User created successfully'
                    ],Response::HTTP_CREATED);
                }               
            }


        }
        // Check for google Id if exist send the user info else create new account
        else if(!empty($request->google_id)){

            $user = DB::table('users')->where('google_id',$request->google_id)->first();

            if($user !==null){

                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' => $user,
                    'message' => 'data successfully selected'
                ],Response::HTTP_OK);

            }else{

                $newUser = new User;
                $newUser->phone = $request->phone;
                $newUser->google_id = $request->google_id;
                $newUser->facebook_id = $request->facebook_id;
                
                if($newUser->save()){
                    return response([
                        'http_response' => Response::HTTP_OK,
                        'data' => $newUser,
                        'message' => 'User created successfully'
                    ],Response::HTTP_CREATED);
                }               
            }

        }
        // Check for facebook Id if exist send user info else create new account and send the new 
        // User info...
        else if(!empty($request->facebook_id)){

            $user = DB::table('users')->where('facebook_id',$request->facebook_id)->first();

            if($user !==null){

                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' => $user,
                    'message' => 'data successfully selected'
                ],Response::HTTP_OK);

            }else{

                $newUser = new User;
                $newUser->phone = $request->phone;
                $newUser->google_id = $request->google_id;
                $newUser->facebook_id = $request->facebook_id;
                
                if($newUser->save()){
                    return response([
                        'http_response' => Response::HTTP_OK,
                        'data' => $newUser,
                        'message' => 'User created successfully'
                    ],Response::HTTP_CREATED);
                }               
            }
        }

    }


    public function usersToFollow(){


        $users = DB::table('user_details')
        ->select('user_id','username','user_profile_picture')
        ->limit(10)
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $users,
            'message' => 'data successfully selected'
        ],Response::HTTP_OK);
    }

    public function getUserDetails(Request $request){


        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }

        $users = DB::table('user_details')
            ->where('user_id',$request->user_id)
            ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $users,
            'message' => 'data successfully selected'
        ],Response::HTTP_OK);
    }



    public function getAllUserFriends(Request $request){

        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }

        $users = DB::table('user_details')
        ->join('friends',function($join){
            $join->on('friends.user2_id','=','user_details.user_id');
            
        })
        ->where('friends.user1_id',$request->user_id)
        ->select(
            'user_details.user_id'
            ,'user_details.username'
            ,'user_details.user_profile_picture')

        ->orderBy('friends.created_at','desc')
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $users,
            'message' => 'data successfully selected'
        ],Response::HTTP_OK);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
