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
        Schema::create('project_drawings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('project_id')->unsigned();
            $table->foreign('project_id')->references('id')
                 ->on('projects')->onDelete('cascade');

            $table->string('title')->nullable();     
            $table->text('description')->nullable();     

            $table->string('image')->nullable();     
            $table->double('width')->nullable();    
            $table->double('height')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_drawings');
    }
};
