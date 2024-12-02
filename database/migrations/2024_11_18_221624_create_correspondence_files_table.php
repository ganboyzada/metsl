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
        Schema::create('correspondence_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('correspondence_id')->unsigned();
            $table->foreign('correspondence_id')->references('id')
                 ->on('correspondences')->onDelete('cascade');

            $table->string('file')->nullable();
            $table->string('type')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correspondence_files');
    }
};
