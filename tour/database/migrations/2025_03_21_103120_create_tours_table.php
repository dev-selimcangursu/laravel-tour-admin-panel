<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('duration');
            $table->string('quota');
            $table->integer('transportation_id');
            $table->integer('starting_place');
            $table->integer('hotel_id');
            $table->string('price');
            $table->string('main_picture');
            $table->integer('directory_id');
            $table->integer('supervisor_id');
            $table->integer('status_id');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
