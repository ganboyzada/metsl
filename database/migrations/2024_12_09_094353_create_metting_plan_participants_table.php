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
        Schema::create('meeting_plan_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('meeting_id')->unsigned();
            $table->foreign('meeting_id')->references('id')
                ->on('meeting_plans')->onDelete('cascade');	
            $table->unsignedBiginteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')
                ->on('users')->onDelete('cascade');	
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metting_plan_participants');
    }
};
