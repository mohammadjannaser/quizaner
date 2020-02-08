<?php

namespace App\Http\Controllers;

use App\Model\Feedback;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return "index";
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        if(empty($request->user_id)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' UserId is Null'
            ],Response::HTTP_NOT_FOUND);

        }

        if(empty($request->feedback)){
              
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' Feedback Text is Null'
            ],Response::HTTP_NOT_FOUND);

        }


        $feedback = new Feedback;

        $feedback->user_id = $request->user_id;
        $feedback->feedback = $request->feedback;

        if($feedback->save()){
            return response([
                'http_response' => Response::HTTP_CREATED,
                'data' => '',
                'message' =>' Feedback Successfully created!'
            ],Response::HTTP_CREATED);
        }else{
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' Creating Feedback Error'
            ],Response::HTTP_NOT_FOUND);
        }
    }


}
