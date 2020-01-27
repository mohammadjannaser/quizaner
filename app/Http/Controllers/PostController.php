<?php

namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Response;
use DB;

use App\Model\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function allPost(Request $request){


        $offset = 0;
        $limite = 5;

        $posts = DB::table('posts')

        ->join('user_details','user_details.user_id','=','posts.user_id')
        ->select('posts.id as post_id','user_details.user_id','user_details.username','user_details.user_profile_picture'
        ,'posts.post_text','posts.post_image','posts.created_at')

        ->offset($offset)
        ->limit($limite)
        ->latest()
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $posts,
            'message' => count($posts) . ' rows has been selected'
        ],Response::HTTP_OK);
    }

    public function getUserPosts(Request $request){
        
        $posts = DB::table('posts')
        ->join('user_details','user_details.user_id','=','posts.user_id')
        ->select('posts.id as post_id','user_details.user_id','user_details.username','user_details.user_profile_picture'
        ,'posts.post_text','posts.post_image','posts.created_at')
        ->where('posts.user_id',$request->user_id)
        ->orderBy('posts.created_at')
        ->limit(5)
        ->get();

        return response([
            'http_response' => Response::HTTP_OK,
            'data' => $posts,
            'message' => count($posts) . ' rows has been selected'
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
