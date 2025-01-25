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
        Schema::create('meeting_plan_notes', function (Blueprint $table) {
            $table->id();


            $table->string('note')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBiginteger('assign_user_id')->nullable()->unsigned();
            $table->foreign('assign_user_id')->references('id')
                ->on('users');	

            $table->date('deadline')->nullable();    
            $table->unsignedBiginteger('meeting_id')->unsigned();
            $table->foreign('meeting_id')->references('id')
                ->on('meeting_plans')->onDelete('cascade');	

            $table->unsignedBiginteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('cascade');	
                $table->date('created_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_plan_notes');
    }
};
