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
        Schema::create('project_document_revisions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('file')->nullable();			
            $table->date('upload_date')->nullable();
			$table->integer('status')->default(1);
            $table->unsignedBiginteger('project_document_id')->unsigned();
            $table->unsignedBiginteger('user_id')->unsigned();
            $table->foreign('project_document_id')->references('id')
                 ->on('project_documents')->onDelete('cascade'); 
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
        Schema::dropIfExists('project_document_reviewer_revisions');
    }
};
