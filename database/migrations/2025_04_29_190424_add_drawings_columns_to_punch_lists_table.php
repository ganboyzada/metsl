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
        Schema::table('punch_lists', function (Blueprint $table) {
            $table->unsignedBiginteger('drawing_id')->unsigned()->nullable();
            $table->foreign('drawing_id')->references('id')
                ->on('project_drawings')->onDelete('cascade');


            $table->double('pin_x')->nullable();    
            $table->double('pin_y')->nullable();  
            $table->double('width')->nullable();    
            $table->double('height')->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('punch_lists', function (Blueprint $table) {
            //
        });
    }
};
