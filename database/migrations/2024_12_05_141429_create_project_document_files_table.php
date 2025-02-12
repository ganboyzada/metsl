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
        Schema::create('project_document_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('project_document_id')->unsigned();
            $table->foreign('project_document_id')->references('id')
                 ->on('project_documents')->onDelete('cascade');

            $table->string('file')->nullable();
            $table->string('type')->nullable();
            $table->double('size')->nullable();
           
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_document_files');
    }
};
