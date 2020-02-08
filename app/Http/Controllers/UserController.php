<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\UserDetail;
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
        ->select('id as user_id','username','user_profile_picture')
        ->limit(10)
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $users,
            'message' => 'data successfully selected'
        ],Response::HTTP_OK);
    }





    public function getUserDetails(Request $request){

        // This is the data that i Want to send back to user.
        $data; 


        //Here we need two user to retrive data.
        // 1 acount id the user id of phone.
        // 2 user id the target user..
        $userAccountId;
        $userId;

        // Here the account id from the request
        if(empty($request->account_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' Accound id is Null'
            ],Response::HTTP_NOT_FOUND);

        }else{
            $userAccountId = $request->account_id;
        }


        // Here get the user id from request
        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }else{
            $userId = $request->user_id;
        }


        // Here get the user data.
        $user = DB::table('user_details')->where('id',$userId)->first();
        $data['userData'] = $user;


        // Now check weather accound user has followed the target user or not.
        $followed = DB::table('followers')
                    ->where('user1_id',$userAccountId)
                    ->where('user2_id',$userId)    
                    ->first();

     

         $data['isFollowed'] = empty($followed) ? '0' : '1';       



        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $data,
            'message' => 'data successfully selected'
        ],Response::HTTP_OK);


    }




    public function saveUserDetails(Request $request){

        $user = new UserDetail;

        if(!empty($request->user_id)){
            $user->id = $request->user_id;
        }
        if(!empty($request->username)){
            $user->username = $request->username;
        }
        if(!empty($request->phone)){
            $user->phone = $request->phone;
        }
        if(!empty($request->dob)){
            $user->dob = $request->dob;
        }
        if(!empty($request->country)){
            $user->country = $request->country;
        }
        if(!empty($request->user_bio)){
            $user->user_bio = $request->user_bio;
        }

        if ($request->has('image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

           
            // Define file path
            $file_path = '/public/images/users/';

            //Store image to the /storage/app/public/images/posts
            $request->file('image_file')->storeAs($file_path, $fileNameToStore);
            
            $user->user_profile_picture = $fileNameToStore;
            

        }
  

        $pastUser = UserDetail::find($user->id);

        if(!empty($pastUser)){
            // User Data already exist so update user

            $isUpdated = $pastUser->update([
                'username' => empty($user->username) ? $pastUser->username : $user->username,
                'phone' => empty($user->phone) ? $pastUser->phone : $user->phone,
                'dob' => empty($user->dob) ? $pastUser->dob : $user->dob,
                'country' => empty($user->country) ? $pastUser->country : $user->country,
                'user_bio' => empty($user->user_bio) ? $pastUser->user_bio : $user->user_bio,
                'user_profile_picture' => empty($user->user_profile_picture) ? $pastUser->user_profile_picture :
                $user->user_profile_picture
            ]);

            if($isUpdated){
                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' => UserDetail::find($user->id),
                    'message' => 'User Data Successfully Saved :)'
                ],Response::HTTP_OK);
            }


        }else if($user->save()){
            // User already does not exist so create user info
            return response([
                'http_response' => Response::HTTP_OK,
                'data' => $user,
                'message' => 'User Data Successfully Saved :)'
            ],Response::HTTP_CREATED);
        }

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
            $join->on('friends.user2_id','=','user_details.id');
            
        })
        ->where('friends.user1_id',$request->user_id)
        ->select(
            'user_details.id as user_id'
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
}
