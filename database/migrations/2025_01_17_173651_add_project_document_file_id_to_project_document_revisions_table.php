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
        Schema::table('project_document_revisions', function (Blueprint $table) {
            $table->unsignedBiginteger('project_document_file_id')->unsigned();
            $table->foreign('project_document_file_id')->references('id')
            ->on('project_document_files')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_document_revisions', function (Blueprint $table) {
            //
        });
    }
};
