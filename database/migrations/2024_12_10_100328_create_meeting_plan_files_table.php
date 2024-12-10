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
        Schema::create('meeting_plan_files', function (Blueprint $table) {
            $table->id();
			$table->unsignedBiginteger('meeting_id')->unsigned();
            $table->foreign('meeting_id')->references('id')
                ->on('meeting_plans')->onDelete('cascade');	
			$table->string('file')->nullable();	
            $table->string('type')->nullable();	
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_planfiles');
    }
};
