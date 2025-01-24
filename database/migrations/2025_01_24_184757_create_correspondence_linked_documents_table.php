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
        Schema::create('correspondence_linked_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('correspondence_id')->unsigned();
            $table->foreign('correspondence_id')->references('id')
                 ->on('correspondences')->onDelete('cascade');

            $table->unsignedBiginteger('file_id')->unsigned()->nullable();
            $table->foreign('file_id')->references('id')
                ->on('project_document_files')->onDelete('cascade'); 
                
            $table->integer('revision_id')->nullable();
      
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correspondence_linked_documents');
    }
};
