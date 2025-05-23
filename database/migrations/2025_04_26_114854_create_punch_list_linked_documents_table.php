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
        Schema::create('punch_list_linked_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('punchList_id')->unsigned();
            $table->foreign('punchList_id')->references('id')
                 ->on('punch_lists')->onDelete('cascade');

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
        Schema::dropIfExists('punch_list_linked_documents');
    }
};
