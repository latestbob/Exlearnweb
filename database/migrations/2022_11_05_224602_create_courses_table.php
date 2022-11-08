<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('coursecode')->unique();
            $table->string('type');
            $table->string('level');
            $table->string('payment_type');
            $table->integer('amount');
            $table->string('tutor');
            $table->integer('minutes')->nullable();
            $table->string('image_url');
            $table->string('tutor_description');
            $table->text('course_description');
            $table->boolean("is_active")->default(true);
            $table->integer("rating")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
