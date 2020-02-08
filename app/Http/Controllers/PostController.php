<?php

namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Response;
use DB;
use Intervention\Image\ImageManagerStatic as Image;

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

        ->join('user_details','user_details.id','=','posts.user_id')
        ->select('posts.id as post_id','user_details.id as user_id','user_details.username','user_details.user_profile_picture'
        ,'posts.post_text','posts.post_image','posts.created_at')

        ->offset($offset)
        ->limit($limite)
        ->latest()
        ->get();

        if(count($posts)>0){
            return response([
                'http_response' => Response::HTTP_OK,
                'data' => $posts,
                'message' => count($posts) . ' rows has been selected'
            ],Response::HTTP_OK);
        }else{
            return response([
                'http_response' => Response::HTTP_NO_CONTENT,
                'data' => $posts,
                'message' => 'No Record Found'
            ],Response::HTTP_OK);
        }


    }

    public function getUserPosts(Request $request){
        
        $posts = DB::table('posts')
        ->join('user_details','user_details.id','=','posts.user_id')
        ->select('posts.id as post_id','user_details.id as user_id','user_details.username','user_details.user_profile_picture'
        ,'posts.post_text','posts.post_image','posts.created_at')
        ->where('posts.user_id',$request->user_id)
        ->orderBy('posts.created_at','desc')
        ->limit(10)
        ->get();

        if(count($posts)>0){
            return response([
                'http_response' => Response::HTTP_OK,
                'data' => $posts,
                'message' => count($posts) . ' rows has been selected'
            ],Response::HTTP_OK);
        }else{
            return response([
                'http_response' => Response::HTTP_NO_CONTENT,
                'data' => $posts,
                'message' => 'No Record Found'
            ],Response::HTTP_OK);
        }

    }

    public function getPost($postId = ''){
        
        return DB::table('posts')
        ->join('user_details','user_details.id','=','posts.user_id')
        ->select('posts.id as post_id','user_details.id as user_id','user_details.username','user_details.user_profile_picture'
        ,'posts.post_text','posts.post_image','posts.created_at')
        ->where('posts.id',$postId)
        ->first();

        

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPost(Request $request)
    {

        $post = new Post;

        if(empty($request->user_id)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'User id can not be null'
            ],Response::HTTP_NOT_FOUND);
        }else{
            $post->user_id = $request->user_id;
        }

        $request->validate([
            'image_file' => 'image|mimes:jpeg,png,jpg|max:1024',
        ]);
  
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
            $file_path = '/public/images/posts/';

            //Store image to the /storage/app/public/images/posts
            $request->file('image_file')->storeAs($file_path, $fileNameToStore);
            
            $post->post_image = $fileNameToStore;
        }

        if(!empty($request->post_text)){
            $post->post_text = $request->post_text;
        }

        if($post->save())
        {
            return response([
                'http_response' => Response::HTTP_CREATED,
                'data' => $this->getPost($post->id),
                'message' => 'Post has been created Successfully :)'
            ],Response::HTTP_CREATED);
        }

    }



    public function updatePost(Request $request)
    {

        $post = new Post;

        if(empty($request->post_id)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Post id can not be null'
            ],Response::HTTP_NOT_FOUND);
        }else{
            $post->id = $request->post_id;
        }

        if(empty($request->user_id)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'User id can not be null'
            ],Response::HTTP_NOT_FOUND);
        }else{
            $post->user_id = $request->user_id;
        }

        $request->validate([
            'image_file' => 'image|mimes:jpeg,png,jpg|max:1024',
        ]);
  
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
            $file_path = '/public/images/posts';

            //Store image to the /storage/app/public/images/posts
            $request->file('image_file')->storeAs($file_path, $fileNameToStore);
        
            
            $post->post_image = $fileNameToStore;
        }

        if(!empty($request->post_text)){
            $post->post_text = $request->post_text;
        }

        $pastPost = Post::find($request->post_id);
    

        $isUpdated = false;

        if($pastPost != null){
                   
            $isUpdated =  $pastPost->update([
        
                'user_id' => empty($post->user_id) ? $pastPost->user_id :$post->user_id,
                'post_text'=> empty($post->post_text) ? $pastPost->post_text :$post->post_text,
                'post_image' => empty($post->post_image) ? $pastPost->post_image :$post->post_image
            ]);

            if($isUpdated){

                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' => $this->getPost($request->post_id),
                    'message' => 'Post updated Successfully :)' 
                ],Response::HTTP_OK);
            }
            
        }else{
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Post Not Found (:' 
            ],Response::HTTP_NOT_FOUND);
        }


    }

    
    public function deletePost(Request $request){

        if(empty($request->post_id)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Post Id is null'
            ],Response::HTTP_NOT_FOUND);
        }

        $post = DB::table('posts')->where('id','=',$request->post_id)->first();
        $check = DB::table('posts')->where('id', '=', $request->post_id)->delete();


        if($check>0){
            return response([
                'http_response' => Response::HTTP_OK,
                'data' => '',
                'message' => 'Post Deleted Successfully'
            ],Response::HTTP_OK);
            
        }else if(empty($post)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Post Not Found'
            ],Response::HTTP_NOT_FOUND);
        }

    }


    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

 
}
