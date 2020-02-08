<?php

namespace App\Http\Controllers;

use DB;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

use App\Model\TestResult;
use Illuminate\Http\Request;

class TestResultController extends Controller
{


    public function getUserTopTenResult(Request $request){


        // This is the last test id of user that has been inrolled and the test is also finished..
      
        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }


        
        $lastTestId = DB::table('test_results')
        ->where('user_id',$request->user_id)
        ->orderBy('created_at','desc')
        ->limit(1)
        ->value('test_id');

        // If User Last tes id is null so get the data from the last test results    
        if(empty($lastTestId)){
            $lastTestId = DB::table('test_results')
            ->orderBy('created_at','desc')
            ->limit(1)
            ->value('test_id');
        }



        $results  = DB::table('user_details')
        ->join('test_results','test_results.user_id','=','user_details.id')
        ->join('tests','tests.id','=','test_results.test_id')

        ->orderBy('test_results.score','desc')
        ->orderBy('test_results.duration_time','asc')
        ->select('user_details.id as user_id'
        ,'user_details.username'
        ,'user_details.user_profile_picture'
        ,'test_results.score'
        ,'tests.test_score'
        ,'test_results.rank'
        ,'test_results.test_id'
        ,'test_results.correct_answer'
        ,'test_results.wrong_answer'
        ,'test_results.duration_time')

        ->where('test_results.test_id',$lastTestId)
        ->limit(10)
        ->get();

        
        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $results,
            'message' => count($results) . ' rows has been selected'
        ],Response::HTTP_OK);

    }

    public function getTestUsersResult(Request $request){

        $message = "";

        if(empty($request->test_id)){
            
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }

        $results  = DB::table('user_details')
        ->join('test_results','test_results.user_id','=','user_details.id')
        ->join('tests','tests.id','=','test_results.test_id')

        ->orderBy('test_results.created_at','desc')
        ->select('user_details.id as user_id'

        ,'user_details.username'
        ,'user_details.user_profile_picture'
        ,'test_results.score'
        ,'tests.test_score'
        ,'tests.test_name'
        ,'tests.test_holding_date'
        ,'test_results.rank'
        ,'test_results.test_id'
        ,'test_results.correct_answer'
        ,'test_results.wrong_answer'
        ,'test_results.duration_time')

        ->where('test_results.test_id',$request->test_id)
     
        ->get();

        
        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $results,
            'message' => count($results) >0 ? count($results) . ' rows has been selected' : 'No Record Found'
        ],Response::HTTP_OK);
    }

    public function getAllUserResult(Request $request){

      
        if(empty($request->user_id)){
            
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }

        $results  = DB::table('user_details')
        ->join('test_results','test_results.user_id','=','user_details.id')
        ->join('tests','tests.id','=','test_results.test_id')

        ->orderBy('test_results.created_at','desc')
        ->select('user_details.id as user_id'

        ,'test_results.score'
        ,'tests.test_score'
        ,'tests.test_name'
        ,'tests.test_holding_date'
        ,'test_results.rank'
        ,'test_results.test_id'
        ,'test_results.correct_answer'
        ,'test_results.wrong_answer'
        ,'test_results.duration_time')

        ->where('test_results.user_id',$request->user_id)
     
        ->get();

        
        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $results,
            'message' => count($results) . ' rows has been selected'
        ],Response::HTTP_OK);
    }

    public function getChallengersResult(Request $request){

        // This is the last test id of user that has been inrolled and the test is also finished..
      
        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }


        
        $lastTestId = DB::table('test_results')
            ->where('user_id',$request->user_id)
            ->orderBy('created_at','desc')
            ->limit(1)
            ->value('test_id');

        // If User Last tes id is null so get the data from the last test results    
        if(empty($lastTestId)){
            $lastTestId = DB::table('test_results')
            ->orderBy('created_at','desc')
            ->limit(1)
            ->value('test_id');
        }



        $results  = DB::table('user_details')
        ->join('test_results','test_results.user_id','=','user_details.id')
        ->join('tests','tests.id','=','test_results.test_id')
        ->join('challengers','challengers.test_id','=','test_results.test_id')

        ->orderBy('test_results.score','desc')
        ->orderBy('test_results.duration_time','asc')
        ->select('user_details.*','test_results.*')

        ->where('test_results.test_id',$lastTestId)
        ->limit(10)
        ->get();

        
        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $results,
            'message' => count($results) . ' rows has been selected'
        ],Response::HTTP_OK);
    }


    public function saveUserResult(Request $request){

        $request->validate([
            'user_id' => 'required',
            'test_id' => 'required',
            'correct_answer' => 'required',
            'wrong_answer' => 'required',
            'score' => 'required',
            'duration_time' => 'required',
        ]);

        $result = new TestResult;

        $result->user_id = $request->user_id;
        $result->test_id = $request->test_id;
        $result->correct_answer = $request->correct_answer;
        $result->wrong_answer = $request->wrong_answer;
        $result->score = $request->score;
        $result->duration_time = $request->duration_time;


        if($result->save()){
            return response([
                'http_response' => Response::HTTP_CREATED,
                'data' => '',
                'message' => "Your Result Succesfully Saved"
            ],Response::HTTP_CREATED);
        }else{
            return response([
                'http_response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => '',
                'message' => "Your Result did not saved"
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;



    }
    

}
