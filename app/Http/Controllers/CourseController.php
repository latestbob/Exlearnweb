<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Section;
use App\Lesson;

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
}
