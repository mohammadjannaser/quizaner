<?php

namespace App\Http\Controllers;

use App\Model\Question;
use App\Model\Answer;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Question\QuestionResource;
use App\Http\Resources\Question\QuestionCollection;

use Intervention\Image\ImageManagerStatic as Image;
use DB;

class QuestionController extends Controller
{

   
    public function getTestQuestions(Request $request){

        $offset = 0;
        $limit = 10;

        if(empty($request->test_id)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' =>' TestId is Null'
            ],Response::HTTP_NOT_FOUND);

        }

        // Check if the request has offset set the offset
        if(!empty($request->offset)){
            $offset = $request->offset;
        }

        // If request has limit set the limit
        if(!empty($request->limit)){
            $limit = $request->limit;
        }


        $questions = DB::table('questions')
            ->join('answers','answers.question_id','=','questions.id')
            ->select('questions.id as question_id'
                    ,'questions.test_id'
                    ,'questions.question_text'
                    ,'questions.question_image'
                    ,'questions.question_type'
                    ,'questions.question_mark'
                    ,'answers.id as answer_id'
                    ,'answers.answer1 as answer1_text'
                    ,'answers.answer1_image'
                    ,'answers.answer2 as answer2_text'
                    ,'answers.answer2_image'
                    ,'answers.answer3 as answer3_text'
                    ,'answers.answer3_image'
                    ,'answers.answer4 as answer4_text'
                    ,'answers.answer4_image'
                    ,'correct_answer')
            ->where('questions.test_id',$request->test_id)
            ->offSet($offset)
            ->limit($limit)
            ->get();

            if(count($questions)>0){
                return response([
                    'http_response' => Response::HTTP_OK,
                    'data' => $questions,
                    'message' => count($questions) . ' rows has been selected'
                ],Response::HTTP_OK);
            }else{
                return response([
                    'http_response' => Response::HTTP_NO_CONTENT,
                    'data' => $questions,
                    'message' => 'No Record Found'
                ],Response::HTTP_OK);
            }



    }

    public function createQuestion(Request $request)
    {

        $question = new Question;
        $answer = new Answer;

       

        $request->validate([
            'question_image_file'=> 'image|mimes:jpeg,png,jpg|max:2048',
            'answer1_image_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            'answer2_image_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            'answer3_image_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            'answer4_image_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            
        ]);
  
        if ($request->has('question_image_file')) {


            // Get filename with extension
            $fileNameWithExtension = $request->file('question_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('question_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

       
            // Define file path
            $file_path = '/public/images/questions';
          
            //Store image to the /storage/app/public/images/tests
            $request->file('question_image_file')->storeAs($file_path, $fileNameToStore);
           
            
            $question->question_image = $fileNameToStore;
        }

        // get and store answer 1 image to the database
        if ($request->has('answer1_image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('answer1_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('answer1_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Define file path
            $file_path = '/public/images/answers';
         
            //Store image to the /storage/app/public/images/tests
            $request->file('answer1_image_file')->storeAs($file_path, $fileNameToStore);
            
            $answer->answer1_image = $fileNameToStore;
        }
        // get and store answer 2 image to the database
        if ($request->has('answer2_image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('answer2_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('answer2_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

         
            // Define file path
            $file_path = '/public/images/answers';
           
            //Store image to the /storage/app/public/images/tests
            $request->file('answer2_image_file')->storeAs($file_path, $fileNameToStore);
     
            $answer->answer2_image = $fileNameToStore;
        }

        // get and store answer 3 image to database
        if ($request->has('answer3_image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('answer3_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('answer3_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Define file path
            $file_path = '/public/images/answers';
           
            //Store image to the /storage/app/public/images/tests
            $request->file('answer3_image_file')->storeAs($file_path, $fileNameToStore);
            
            $answer->answer3_image = $fileNameToStore;
        }

        // get and store answer 4 image to the database
        if ($request->has('answer4_image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('answer4_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('answer4_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Define file path
            $file_path = '/public/images/answers';
            
            //Store image to the /storage/app/public/images/tests
            $request->file('answer4_image_file')->storeAs($file_path, $fileNameToStore);
           
            $answer->answer4_image = $fileNameToStore;
        }

        if(!empty($request->test_id)){
            $question->test_id = $request->test_id;
        }
        if(!empty($request->question_text)){
            $question->question_text = $request->question_text;
        }

        if(!empty($request->question_mark)){
            $question->question_mark = $request->question_mark;
        }

    
        if(!empty($request->answer1_text)){
            $answer->answer1 = $request->answer1_text;
        }
         
        if(!empty($request->answer2_text)){
            $answer->answer2 = $request->answer2_text;
        }
         
        if(!empty($request->answer3_text)){
            $answer->answer3 = $request->answer3_text;
        }
         
        
        if(!empty($request->answer4_text)){
            $answer->answer4 = $request->answer4_text;
        }

         
        if(!empty($request->correct_answer)){
            $answer->correct_answer = $request->correct_answer;
        }


        if($question->save()){
            $answer->question_id = $question->id;

            if($answer->save()){
                return response([
                    'http_response' => Response::HTTP_CREATED,
                    'data' => '',
                    'message' => 'Question Successfully Created :)' 
                ],Response::HTTP_CREATED);
        
            } else{
                return response([
                    'http_response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                    'data' => '',
                    'message' => 'Creating Answer Failed (:' 
                ],Response::HTTP_INTERNAL_SERVER_ERROR);   
            }      
        }else{
            return response([
                'http_response' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => '',
                'message' => 'Creating Question Failed (:' 
            ],Response::HTTP_INTERNAL_SERVER_ERROR);   
        }

    }



    public function updateQuestion(Request $request)
    {

        $question = new Question;
        $answer = new Answer;

       

        $request->validate([
            'question_image_file'=> 'image|mimes:jpeg,png,jpg|max:2048',
            'answer1_image_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            'answer2_image_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            'answer3_image_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            'answer4_image_file' => 'image|mimes:jpeg,png,jpg|max:2048',
            
        ]);
  
        if ($request->has('question_image_file')) {


            // Get filename with extension
            $fileNameWithExtension = $request->file('question_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('question_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Define file path
            $file_path = '/public/images/questions';
          
            //Store image to the /storage/app/public/images/tests
            $request->file('question_image_file')->storeAs($file_path, $fileNameToStore);
     
            
            $question->question_image = $fileNameToStore;
        }

        // get and store answer 1 image to the database
        if ($request->has('answer1_image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('answer1_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('answer1_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Define file path
          
            //Store image to the /storage/app/public/images/tests
            $request->file('answer1_image_file')->storeAs($file_path, $fileNameToStore);
  
            
            $answer->answer1_image = $fileNameToStore;
        }
        // get and store answer 2 image to the database
        if ($request->has('answer2_image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('answer2_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('answer2_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;


            // Define file path
            $file_path = '/public/images/answers';
          
            //Store image to the /storage/app/public/images/tests
            $request->file('answer2_image_file')->storeAs($file_path, $fileNameToStore);
        
            $answer->answer2_image = $fileNameToStore;
        }

        // get and store answer 3 image to database
        if ($request->has('answer3_image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('answer3_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('answer3_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            // Define file path
            $file_path = '/public/images/answers';
       
            //Store image to the /storage/app/public/images/tests
            $request->file('answer3_image_file')->storeAs($file_path, $fileNameToStore);
    
            
            $answer->answer3_image = $fileNameToStore;
        }

        // get and store answer 4 image to the database
        if ($request->has('answer4_image_file')) {

            // Get filename with extension
            $fileNameWithExtension = $request->file('answer4_image_file')->getClientOriginalName();

            // Get filename with out extension
            $filename = pathinfo($fileNameWithExtension,PATHINFO_FILENAME);

            // Get file extension
            $extension = $request->file('answer4_image_file')->getClientOriginalExtension();


            // Make a image name based on user name and current timestamp and tet name
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

           
            // Define file path
            $file_path = '/public/images/answers';

            //Store image to the /storage/app/public/images/tests
            $request->file('answer4_image_file')->storeAs($file_path, $fileNameToStore);
            

            
            
            $answer->answer4_image = $fileNameToStore;
        }

        if(!empty($request->test_id)){
            $question->test_id = $request->test_id;
        }
        if(!empty($request->question_text)){
            $question->question_text = $request->question_text;
        }

        if(!empty($request->question_mark)){
            $question->question_mark = $request->question_mark;
        }

    
        if(!empty($request->answer1_text)){
            $answer->answer1 = $request->answer1_text;
        }
         
        if(!empty($request->answer2_text)){
            $answer->answer2 = $request->answer2_text;
        }
         
        if(!empty($request->answer3_text)){
            $answer->answer3 = $request->answer3_text;
        }
         
        
        if(!empty($request->answer4_text)){
            $answer->answer4 = $request->answer4_text;
        }

         
        if(!empty($request->correct_answer)){
            $answer->correct_answer = $request->correct_answer;
        }

        $answer->question_id = $request->question_id;
        $pastQuestion = Question::find($request->question_id);
        $pastAnswer = Answer::where('question_id',$pastQuestion->id)->first();
        $isUpdated = false;

        if($pastQuestion != null){
                   
            $isUpdated =  $pastQuestion->update([
                'test_id' =>       empty($request->test_id) ? $pastQuestion->test_id :$request->test_id,
                'question_text' => empty($request->question_text) ? $pastQuestion->question_text :$request->question_text,
                'question_image'=> empty($question->question_image) ? $pastQuestion->question_image :$question->question_image,
                'question_type' => empty($request->question_type) ? $pastQuestion->question_type :$request->question_type,
                'question_mark' => empty($request->question_mark) ? $pastQuestion->question_mark :$request->question_mark
            ]);
           
            
        }else{
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Question Not Found (:' 
            ],Response::HTTP_NOT_FOUND);
        }

        
        if($pastAnswer != null){

            $isUpdated = $pastAnswer->update([

                'question_id' => empty($answer->question_id) ? $pastAnswer->question_id :$answer->question_id,
                'answer1' => empty($answer->answer1) ? $pastAnswer->answer1 :$answer->answer1,
                'answer1_image'=> empty($answer->answer1_image) ? $pastAnswer->answer1_image :$answer->answer1_image,

                'answer2' => empty($answer->answer2) ? $pastAnswer->answer2 :$answer->answer2,
                'answer2_image' => empty($answer->answer2_image) ? $pastAnswer->answer2_image :$answer->answer2_image,

                'answer3' => empty($answer->answer3) ? $pastAnswer->answer3 :$answer->answer3,
                'answer3_image'=> empty($answer->answer3_image) ? $pastAnswer->answer3_image :$answer->answer3_image,

                'answer4' => empty($answer->answer4) ? $pastAnswer->answer4 :$answer->answer4,
                'answer4_image' => empty($answer->answer4_image) ? $pastAnswer->answer4_image :$answer->answer4_image,

                'correct_answer' =>empty($answer->correct_answer) ? $pastAnswer->correct_answer :$answer->correct_answer
            ]);

        }else{
            $answer->save();
        }

        if($isUpdated){

            return response([
                'http_response' => Response::HTTP_NO_CONTENT,
                'data' => '',
                'message' => 'Question Successfully Updated :)' 
            ],Response::HTTP_OK);

        }else{
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Question Update Failed (:' 
            ],Response::HTTP_NOT_FOUND);
        }
    }



    public function deleteQuestion(Request $request){

        if(empty($request->question_id)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Question Id is null'
            ],Response::HTTP_NOT_FOUND);
        }
        $question = DB::table('questions')->where('id', '=', $request->question_id)->first();
        $check = DB::table('questions')->where('id', '=', $request->question_id)->delete();

        if($check>0){
            return response([
                'http_response' => Response::HTTP_OK,
                'data' => '',
                'message' => 'Question Deleted Successfully'
            ],Response::HTTP_OK);
        
        }else if(empty($question)){
            return response([
                'http_response' => Response::HTTP_NOT_FOUND,
                'data' => '',
                'message' => 'Question Not Found'
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
