<?php

namespace App\Http\Controllers;

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
        //
    }
}
