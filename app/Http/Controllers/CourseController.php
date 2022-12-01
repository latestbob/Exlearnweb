<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Section;
use App\Lesson;
use App\Order;
use App\Paystack;
use App\Feeback;
use App\User;
use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;


class CourseController extends Controller
{
    //course home

    public function index(){
        $course = Course::all();


        return view('course',compact('course'));
    }

    // $table->string('title');
    // $table->string('coursecode')->unique();
    // $table->string('type');
    // $table->string('level');
    // $table->string('payment_type');
    // $table->integer('amount');
    // $table->string('tutor');
    // $table->integer('minutes')->nullable();
    // $table->string('image_url');
    // $table->string('tutor_description');
    // $table->text('course_description');

    //create course

    public function createcourse(Request $request){
        $min = 100000;
        $max = 9000000;
        $rand = rand($min, $max);

        $coursecode = (string) $rand;
       $course = new Course;

       $course->title = $request->title;
       $course->coursecode = $coursecode;
       $course->type = $request->type;
       $course->level = $request->level;
       $course->payment_type = $request->payment_type;
       $course->amount = $request->amount;
       $course->tutor = $request->tutor;
       $course->tutor_description = $request->tutor_description;
       $course->image_url = $request->image_url;
       $course->course_description = $request->course_description;

       $course->save();

       return back()->with('msg','Course Created Successfully');
       
    }


    //course sections

    public function sections($id){
        $course = Course::find($id);
        $coursecode = Course::where('id',$id)->value('coursecode');

        $sections = Section::where('coursecode',$coursecode)->get();

        // dd($course);
         return view('section',compact('course','sections'));
    }

    //create a section

    public function coursesection(Request $request){

        $min = 1000000;
        $max = 12000000;
        $rand = rand($min, $max);

        $sectioncode = (string) $rand;

        $section = new Section;
        $section->coursecode = $request->coursecode;
        $section->title = $request->title;
        $section->section_code = $sectioncode;

        $section->save();

        return back()->with('msg','Section Created Successfully');
        
    }

    //course lessons

    public function sectionlessons($id){

        $section = Section::find($id);
        $section_code = Section::where('id',$id)->value('section_code');

        $lessons = Lesson::where('section_code',$section_code)->get();

        return view('lessons',compact('section','lessons'));
    }

    //create lesson

    public function createlessons(Request $request){
        $lesson = new Lesson;
        $lesson->section_code = $request->section_code;
        $lesson->title = $request->title;
        $lesson->video_url = $request->video_url;
        $lesson->minutes = $request->minutes;
        $lesson->save();

        return back()->with('msg','Lesson Created Successfully');
        
    }





    ///////////////////////////ALL API ROUTES HERE ////////////////////////////////

    public function getallcourses(){

        
        $course  = Course::all();

        return response()->json($course);
    }

    //get unique course

    public function getuniquecourse($coursecode){
        $course = Course::where('coursecode',$coursecode)->first();

        return response()->json($course);
    }


    //get all sections in a course

    public function getallsections($coursecode){
        $section = Section::where('coursecode',$coursecode)->get();

       // return response()->json($section);

       $myarray = [];

       foreach($section as $sections){
           $lesson = Lesson::where('section_code',$sections->section_code)->sum("minutes");

           $myarray[] = [
               "section" => $sections,
               "minutes" => $lesson
           ];
       }

       return $myarray;
    }


    //get Unique Section

    public function getUniqueSection($section_code){
        $section = Section::where('section_code',$section_code)->first();
        return response()->json($section);
    }

    //get lessons in a section

    public function getLessons($section_code){
        $lesson = Lesson::where('section_code',$section_code)->get();
        
        return response()->json($lesson);
    }

    //get unique lesson

    public function getUniquelesson($id){

        $lesson = Lesson::find($id);

        return response()->json($lesson);
    }

    //////////////////////////////////////////////////////




    ///get free courses

    public function free(){
        $free = Course::where('payment_type',"Free")->get();

        return $free;
    }

    //payment route

    public function payment(Request $request){
       
        $validator = Validator::make($request->all(), [
          
           
            'email' => 'required|string|email:rfc,dns|max:255|exists:users,email',
            
            'coursecode' => 'required',
            'reference' => 'required',
            'amount' => 'required'
            
           
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 'failed',
                'message' => $validator->errors()
            ],400);
        }

    $course = Course::where('coursecode',$request->coursecode)->first();

        $order = new Order;
        $order->email = $request->email;
        $order->coursecode = $request->coursecode;
        $order->reference = $request->reference;
        $order->amount = $request->amount;
        $order->save();

        return response()->json($course);




        }

        //get purchaed Course

        public function purchased($email){
           
            $order = Order::where('email',$email)->get();

                $course = [];
            foreach($order as $items){

                $mycourse = Course::where('coursecode',$items->coursecode)->first();

                $course[] = [
                    "coursecode" => $items->coursecode,
                    "course" => $mycourse               
                ];

            }

            return $course;
        }


        // get my course for a user

    public function showcourses(Request $request,$email){

        //if request search

        $search = $request->search;

        if($search){
            $course = Course::when($search, function($query, $search){
                $query->where('title', 'LIKE', "%{$search}%")
             
                ->orWhere('type', 'LIKE', "%{$search}%")
                ->orWhere('level', 'LIKE', "%{$search}%")
                ;
                ;
            })->paginate(10);

            $showcourse = [];

            foreach($course as $items){
                $order = Order::where('email',$email)->where('coursecode',$items->coursecode)->exists();

                if(!$order){
                    $showcourse[]=[
                        "course" => $items
                    ];
                }
            }

            return $showcourse;
    
        }

        elseif($search == null) {

        
            //return "working";
                   $course = Course::all();

       $showcourse = [];

       foreach($course as $items){
        $order = Order::where('email',$email)->where('coursecode',$items->coursecode)->exists();

        if(!$order){
            $showcourse[]=[
                "course" => $items
            ];
        }
       }

       return $showcourse;
    
    }
}


///public paystack 

public function getpublickey(){
    
    $paystack = Paystack::where("gateway","paystack")->value("public_key");


    return response()->json([
        "status" => "success",
        "public_key" => $paystack
    ]);

}


public function feedback(Request $request){
    $validator = Validator::make($request->all(), [
          
           
        'email' => 'required|string|email:rfc,dns|max:255|exists:users,email',
        
     
        'feedback' => 'required'
        
       
    ]);

    if ($validator->fails()) {
        return response([
            'status' => 'failed',
            'message' => $validator->errors()
        ],400);
    }

   $feedback = new Feeback;
   $feedback->email = $request->email;
   $feedback->feedback = $request->feedback;
   $feedback->save();

   $username = User::where("email",$request->email)->value("name");

   return response()->json([
       "status"=>"success",
       "message"=>"Thanks ".$username. " your feedback has been received."
   ]);
}

//get feedbacks

public function feedbacks(){
    $feedback = Feeback::all();
    return response()->json([
        'status' => 'success',
        'feedbacks' => $feedback
    ]);
}


}
