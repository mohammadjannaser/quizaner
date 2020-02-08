<?php

namespace App\Http\Controllers;

use DB;

use Symfony\Component\HttpFoundation\Response;

use App\Model\Test;
use Illuminate\Http\Request;
use App\Http\Resources\Test\TestResource;
use App\Http\Resources\Test\TestCollection;
use App\Http\Requests\TestRequest;
use App\Traits\UploadTrait;
use Intervention\Image\ImageManagerStatic as Image;

class TestController extends Controller
{



    public function allTest(){
    
        $tests = DB::table('tests')
                    ->join('user_details', function ($join) {
                        $join->on('user_details.id', '=', 'tests.user_id')
                        ->where('tests.user_id', '>', 20)
                        ->where(function($query){
                            $query->where('tests.user_id',30)
                            ->orWhere('user_details.id',40);

                        });
                    })
                    ->select('user_details.id as user_id','user_details.username',
                                'tests.test_name','tests.test_image','tests.test_holding_date',
                                'tests.id as test_id')
                    ->orderBy('tests.id','desc')
                    ->get();

        return $tests;
    }

    public function getTestDetails(Request $request){

        if(empty($request->test_id)){
            
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' test_id is Null'
            ],Response::HTTP_NOT_FOUND);

        }
        $test = DB::table('tests')
        ->where('tests.id',$request->test_id)
        ->get();

        if(count($test)>0){

            return response([
                'http_response' => Response::HTTP_OK,
                'data' => $test,
                'message' => count($test) . ' rows has been selected'
            ],Response::HTTP_OK);
        }else{
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' Test Does not Exist'
            ],Response::HTTP_NOT_FOUND);
        }

    }

    public function topTest(){


        $tests = DB::table('tests')
        ->join('user_details','user_details.id','=','tests.user_id')
        ->select('user_details.id as user_id',
                'user_details.username',
                'tests.test_name',
                'tests.test_image',
                'tests.test_holding_date',
        'tests.id as test_id')
        ->orderBy('tests.created_at','desc')
    
        ->limit(5)
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $tests,
            'message' => count($tests) . ' rows has been selected'
        ],Response::HTTP_OK);
     
    }

    public function getUserQuizzes(Request $request){

        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }

        
        $tests = DB::table('tests')
         
            ->select('tests.test_name','tests.test_image','tests.test_holding_date',
            'tests.id as test_id','tests.user_id')
            ->where('tests.user_id',$request->user_id)
            ->limit(5)
            ->get();

                    
        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $tests,
            'message' => count($tests) . ' rows has been selected'
        ],Response::HTTP_OK);
    }


    public function getStudentEnrolledTest(Request $request){

        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }


        $tests = DB::table('enrolled_users')
                    ->join('tests','tests.id', '=', 'enrolled_users.test_id')
                    ->join('user_details','user_details.id','=','tests.user_id')
                    ->where('enrolled_users.user_id', $request->user_id)
                    ->select(
                        'tests.id as test_id'
                        ,'tests.test_name'
                        ,'tests.test_holding_date'
                        ,'user_details.username'
                        ,'tests.test_image'
                        )
                    ->get();

                    
        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $tests,
            'message' => count($tests) . ' rows has been selected'
        ],Response::HTTP_OK);

    }
    
    public function getUserQuizzesReport(Request $request){

        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }

        
        $tests = DB::table('tests')
            ->join('user_details','user_details.id','=','tests.user_id')
            
            ->select('tests.test_name','tests.test_image','tests.test_holding_date',
            'tests.id as test_id','tests.user_id')
            ->where('tests.user_id',$request->user_id)
            ->get();

                    
        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $tests,
            'message' => count($tests) . ' rows has been selected'
        ],Response::HTTP_OK);
    }

    public function getTestEnrolledUsers(Request $request){
        
        if(empty($request->test_id)){
            
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' test_id is Null'
            ],Response::HTTP_NOT_FOUND);

        }


        $users = DB::table('user_details')
        ->join('enrolled_users','enrolled_users.user_id','user_details.id')
    
        ->select('user_details.id as user_id','user_details.username','user_details.user_profile_picture')
        ->where('enrolled_users.test_id',$request->test_id)
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $users,
            'message' => count($users) ?  count($users) . ' rows has been selected' : 'No Record Found' 
        ],Response::HTTP_OK);


    }

    public function createTest(Request $request)
    {

        $test = new Test;

        // $request->validate([
        //     'image_file' => 'image|mimes:jpeg,png,jpg|max:1024',
        // ]);
  
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
            $file_path = '/public/images/tests';

            //Store image to the /storage/app/public/images/tests
            $request->file('image_file')->storeAs($file_path, $fileNameToStore);

            $test->test_image = $fileNameToStore;
        }

        if(!empty($request->user_id)){
            $test->user_id = $request->user_id;
        }
        if(!empty($request->test_name)){
            $test->test_name = $request->test_name;
        }

        if(!empty($request->test_duration)){
            $test->test_duration = $request->test_duration;
        }
        if(!empty($request->number_of_question)){
            $test->number_of_question = $request->number_of_question;
        }
        if(!empty($request->test_score)){
            $test->test_score = $request->test_score;
        }
        if(!empty($request->test_holding_date)){
            $test->test_holding_date = $request->test_holding_date;
        }

        if(!empty($request->test_description)){
            $test->test_description = $request->test_description;
        }
        if(!empty($request->test_cost)){
            $test->test_cost = $request->test_cost;
        }
        if(!empty($request->test_privacy)){
            $test->test_privacy = $request->test_privacy;
        }
        if(!empty($request->test_category)){
            $test->test_category = $request->test_category;
        }

        // Create new Test
        if($test->save()){
            return response([
                'http_response' => Response::HTTP_CREATED,
                'data' => $test,
                'message' => 'Test Successfully Created :)' 
            ],Response::HTTP_CREATED);
        }

    }

    public function updateTest(Request $request)
    {

        $test = new Test;

        // $request->validate([
        //     'image_file' => 'image|mimes:jpeg,png,jpg|max:1024',
        // ]);
  
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
            $file_path = '/public/images/tests';

            //Store image to the /storage/app/public/images/tests
            $request->file('image_file')->storeAs($file_path, $fileNameToStore);
          
            
            
            $test->test_image = $fileNameToStore;
        }

        if(!empty($request->test_id)){
            $test->id = $request->test_id;
        }

        if(!empty($request->user_id)){
            $test->user_id = $request->user_id;
        }
        if(!empty($request->test_name)){
            $test->test_name = $request->test_name;
        }

        if(!empty($request->test_duration)){
            $test->test_duration = $request->test_duration;
        }
        if(!empty($request->number_of_question)){
            $test->number_of_question = $request->number_of_question;
        }
        if(!empty($request->test_score)){
            $test->test_score = $request->test_score;
        }
        if(!empty($request->test_holding_date)){
            $test->test_holding_date = $request->test_holding_date;
        }

        if(!empty($request->test_description)){
            $test->test_description = $request->test_description;
        }
        if(!empty($request->test_cost)){
            $test->test_cost = $request->test_cost;
        }
        if(!empty($request->test_privacy)){
            $test->test_privacy = $request->test_privacy;
        }
        if(!empty($request->test_category)){
            $test->test_category = $request->test_category;
        }

        if(!empty($request->test_id)){
            // Update already Test
            $pastTest = Test::find($request->test_id);

            $isUpdated = false;

            if($pastTest != null){
                       
                $isUpdated =  $pastTest->update([
                    'test_id'               => empty($test->id) ? $pastTest->test_id :$test->test_id,
                    'user_id'               => empty($test->user_id) ? $pastTest->user_id :$test->user_id,
                    'test_name'             => empty($test->test_name) ? $pastTest->test_name :$test->test_name,
                    'number_of_question'    => empty($test->number_of_question) ? $pastTest->number_of_question :$test->number_of_question,
                    'test_score'            => empty($test->test_score) ? $pastTest->test_score :$test->test_score,
                    'test_holding_date'     => empty($test->test_holding_date) ? $pastTest->test_holding_date :$test->test_holding_date,
                    'test_description'      => empty($test->test_description) ? $pastTest->test_description :$test->test_description,
                    'test_cost'             => empty($test->test_cost) ? $pastTest->test_cost :$test->test_cost,
                    'test_privacy'          => empty($test->test_privacy) ? $pastTest->test_privacy :$test->test_privacy,
                    'test_duration'         => empty($test->test_duration) ? $pastTest->test_duration :$test->test_duration,
                    'test_category'         => empty($test->test_category) ? $pastTest->test_category :$test->test_category,
                    'test_image'            => empty($test->test_image) ? $pastTest->test_image :$test->test_image,

                ]);
                if($isUpdated){

                    return response([
                        'http_response' => Response::HTTP_OK,
                        'data' => $test,
                        'message' => 'Test updated Successfully (:' 
                    ],Response::HTTP_OK);
                }
               
                
            }else{
                return response([
                    'http_response' => Response::HTTP_NOT_FOUND,
                    'data' => [],
                    'message' => 'Test Not Found (:' 
                ],Response::HTTP_NOT_FOUND);
            }

        }

    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }


    public function getTestCategory(){
        

        $category = DB::table('test_categories')
        ->select('id','category_name')
        ->get();
        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $category,
            'message' => count($category) ?  count($category) . ' rows has been selected' : 'No Record Found' 
        ],Response::HTTP_OK);


    }

    public function deleteTest(Request $request){

        if(empty($request->test_id)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Test Id is null'
            ],Response::HTTP_NOT_FOUND);
        }

        $test = DB::table('tests')->where('id','=',$request->test_id)->first();
        $check = DB::table('tests')->where('id', '=', $request->test_id)->delete();


        if($check>0){
            return response([
                'http_response' => Response::HTTP_OK,
                'data' => '',
                'message' => 'Test Deleted Successfully'
            ],Response::HTTP_OK);
            
        }else if(empty($test)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Test Not Found'
            ],Response::HTTP_NOT_FOUND);
        }

    }


    public function suggestionsTest(Request $request){

        $offset = 5;
        $limite = 6;
        $userId;

        if(!empty($request->user_id)){
            $userId = $request->user_id;
        }


        if(!empty($request->offset)){
            $offset = $request->offset;
        }  

        if(!empty($request->limite)){
            $limite = $request->limite;
        }


        $tests = DB::table('tests')
        ->join('user_details','user_details.id','=','tests.user_id')
        ->select('user_details.id as user_id','user_details.username','tests.test_name','tests.test_image','tests.test_holding_date',
        'tests.id as test_id')
        ->offset($offset)
        ->limit($limite)
        ->where('tests.user_id','<>',$userId)
        ->orderBy('tests.created_at','desc')
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $tests,
            'message' => count($tests) . ' rows has been selected'
        ],Response::HTTP_OK);
    }


    public function moreQuizzes(Request $request){

        $userId;

        if(!empty($request->user_id)){
            $userId = $request->user_id;
        }

        

        $offset = 11;
        $limite = 10; 

        $tests = DB::table('tests')
        ->join('user_details','user_details.id','=','tests.user_id')
        ->select('user_details.id as user_id','user_details.username','tests.test_name','tests.test_image','tests.test_holding_date',
        'tests.id as test_id')
        ->offset($offset)
        ->limit($limite)
        ->where('tests.user_id','<>',$userId)


        ->orderBy('tests.created_at','desc')
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $tests,
            'message' => count($tests) . ' rows has been selected'
        ],Response::HTTP_OK);


    }



    public function getAllTestDetails(Request $request){
        
          // Here I need three id 
        // 1. test id that i will get from request.
        // 2. user account id that again i will get from the request..
        // 3. user id the creator of test (instructor id)
        
        $testId;
        $userAccountId;
        $userId;
        // This is the data that will be return to user.
        $data;

        if(empty($request->test_id)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' test_id is Null'
            ],Response::HTTP_NOT_FOUND);

        }else{

            // Get TestId here from request
            $testId = $request->test_id;
        }


        // This user id is user account id the one who requested the test details
        // this user id is not the owner of test
        // Ther the test owner id will be in the test table.
        if(empty($request->user_id)){
            
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' user id is Null'
            ],Response::HTTP_NOT_FOUND);

        }else{
            // I get UserAccountId here from Request...
            $userAccountId = $request->user_id;
        }

        // Get Test Detail by test id
        //$test = Test::find($testId);
        $test = DB::table('tests')->where('id',$testId)
                ->select('id as test_id','user_id','test_name','test_duration','number_of_question','test_score'
                ,'test_holding_date','test_description','test_cost','test_image')
                ->first();

        $data['test'] = $test;

        if(!empty($test)){
            // Get test owner here from test row...
            $userId = $test->user_id;

        }else{
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>'Test Not Found'
            ],Response::HTTP_NOT_FOUND);
        }
        

        // Now get the test owner information
        $testOwner = DB::table('user_details')
                ->select('username','user_profile_picture','user_bio')
                ->where('id',$userId)
                ->first();

        $data['testOwner'] = $testOwner;


        // Now Check Weather user has enrolled for this test or not.
        $enrolled = DB::table('enrolled_users')
                    ->where('user_id',$userAccountId)
                    ->where('test_id',$testId)
                    ->first();

        $data['isEnrolled'] = empty($enrolled) ? '0' : '1';          


        // Now Check Weather user has followed the test owner or not.
        $followed = DB::table('followers')
                    ->where('user1_id',$userAccountId)
                    ->where('user2_id',$userId)    
                    ->first();

         $data['isFollowed'] = empty($followed) ? '0' : '1';           
    

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $data,
            'message' => 'Data has been successfully Recieved'
        ],Response::HTTP_OK);

      
        
    }



}
