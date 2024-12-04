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
			$table->string('number')->nullable()->index();
			$table->string('subject')->nullable()->index();
			$table->char('type')->nullable();
			$table->char('status')->nullable();
			$table->char('program_impact')->nullable();
			$table->char('cost_impact')->nullable();
			$table->longText('description')->nullable();

            $table->unsignedBiginteger('recieved_from')->unsigned();
            $table->foreign('recieved_from')->references('id')
                 ->on('users')->onDelete('cascade');

            $table->date('created_date')->nullable();
			$table->date('recieved_date')->nullable();

            $table->unsignedBiginteger('project_id')->unsigned();
            $table->foreign('project_id')->references('id')
                 ->on('projects')->onDelete('cascade');

            $table->unsignedBiginteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('cascade');

            $table->integer('reply_correspondence_id')->nullable();    



            $table->unique(['number' , 'subject']);     
			
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
