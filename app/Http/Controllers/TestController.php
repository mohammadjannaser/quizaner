<?php

namespace App\Http\Controllers;

use DB;

use Symfony\Component\HttpFoundation\Response;

use App\Model\Test;
use Illuminate\Http\Request;
use App\Http\Resources\Test\TestResource;
use App\Http\Resources\Test\TestCollection;
use App\Http\Requests\TestRequest;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TestCollection::collection(Test::paginate(5));
    }

    public function allTest(){
    
 

        $tests = DB::table('tests')
                    ->join('user_details', function ($join) {
                        $join->on('user_details.user_id', '=', 'tests.user_id')
                        ->where('tests.user_id', '>', 20)
                        ->where(function($query){
                            $query->where('tests.user_id',30)
                            ->orWhere('user_details.user_id',40);

                        });
                    })
                    ->select('user_details.user_id','user_details.username',
                                'tests.test_name','tests.test_image','tests.test_holding_date',
                                'tests.id as test_id')
                    ->orderBy('tests.id','desc')
                    ->get();

        return $tests;
    }


    public function topTest(){


        $tests = DB::table('tests')
        ->join('user_details','user_details.user_id','=','tests.user_id')
        ->select('user_details.username','tests.test_name','tests.test_image','tests.test_holding_date',
        'tests.id as test_id')
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
            ->join('user_details','user_details.user_id','=','tests.user_id')
            ->select('user_details.username','tests.test_name','tests.test_image','tests.test_holding_date',
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


        $tests = DB::table('inrolled_users')
                    ->join('tests','tests.id', '=', 'inrolled_users.test_id')
                    ->join('user_details','user_details.user_id','=','tests.user_id')
                    ->where('inrolled_users.user_id', $request->user_id)
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
    public function store(TestRequest $request)
    {
        $test = new Test;
        $test->instructor_id = $request->instructor_id;
        $test->test_name = $request->test_name;
        $test->test_duration = $request->test_duration;
        $test->number_of_question = $request->number_of_question;
        $test->test_score = $request->test_score;
        $test->test_holding_date = $request->test_holding_date;
        $test->test_description = $request->test_description;
        $test->test_cost = $request->test_cost;
        $test->test_privacy = $request->test_privacy;
        $test->test_category = $request->test_category;
        $test->test_image = $request->test_image;

        $test->save();

        return response([
            'data' => new TestResource($test)
        ],Response::HTTP_CREATED);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        return new TestResource($test);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(TestRequest $request, Test $test)
    {


        if($test->update($request->all())){
            // send success response
            return response([
                'data' => new TestResource($test)
            ],200);
    
        }else{
            // send failed response
            return response([
                'data' => 'update Failed try again' 
            ],404);
    
        }

      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        
        if($test->delete()){
            // send success response
            return response([
                'data' => 'Test deleted Successfully'
            ],200);
    
        }else{
            // send failed response
            return response([
                'data' => 'delete Failed try again' 
            ],404);
    
        }

    
    }
}
