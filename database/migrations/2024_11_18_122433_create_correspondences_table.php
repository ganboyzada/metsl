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
        Schema::create('correspondences', function (Blueprint $table) {
            $table->id();
			$table->string('number')->nullable();
			$table->string('subject')->nullable();
			$table->integer('private')->default(0);
			$table->char('status')->nullable();
			$table->char('program_impact')->nullable();
			$table->char('cost_impact')->nullable();
			$table->longText('description')->nullable();
			$table->integer('distribution_member')->nullable();
			$table->integer('recieved_from')->nullable();	
			$table->date('recieved_date')->nullable();
			
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correspondences');
    }
};
