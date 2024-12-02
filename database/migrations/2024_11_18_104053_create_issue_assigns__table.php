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
        Schema::create('issue_assigns_', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id');
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');

            $table->foreignId('project_id');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade'); 
            
            $table->integer('issueable_id')->nullable();
            $table->string('issueable_type')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_assigns_');
    }
};
