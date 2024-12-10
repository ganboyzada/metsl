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
        Schema::create('meeting_plans', function (Blueprint $table) {
            $table->id();
			$table->string('number')->nullable()->index();
			$table->string('name')->nullable()->index();
			$table->string('link')->nullable();
			$table->string('location')->nullable();
			$table->date('planned_date')->nullable();
			$table->time('start_time')->nullable();
			$table->string('duration')->nullable();
			$table->string('timezone')->nullable();
			$table->LongText('purpose')->nullable();
			$table->integer('status')->default(1);
            $table->unsignedBiginteger('project_id')->unsigned();
            $table->foreign('project_id')->references('id')
                ->on('projects')->onDelete('cascade');				
            $table->unsignedBiginteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('cascade');			
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metting_plans');
    }
};
