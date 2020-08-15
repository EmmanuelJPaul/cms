<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_details', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('staff_id')->nullable();
            $table->bigInteger('phone_number')->nullable();
            $table->string('gender', 16)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('permanent_address', 128)->nullable();
            $table->string('present_address', 128)->nullable();
            $table->string('pan_card_number', 10)->nullable();
            $table->string('aadhar_card_number', 12)->nullable();
            $table->string('department', 32)->nullable();
            $table->string('designation', 32)->nullable();
            $table->string('anna_university_id', 32)->nullable();
            $table->string('aicte_id', 32)->nullable();
            $table->string('avatar')->default('default');
            $table->json('academic_qualification')->default('[]');
            $table->json('experience')->default('[]');
            $table->json('journal')->default('[]');
            $table->json('conference')->default('[]');
            $table->json('online_course')->default('[]');
            $table->json('book')->default('[]');
            $table->json('fdp')->default('[]');
            $table->json('workshop')->default('[]');
            $table->json('award')->default('[]');
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
        Schema::dropIfExists('staff_details');
    }
}
