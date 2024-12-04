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
        Schema::create('correspondence_distribution_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('correspondence_id')->unsigned();
            $table->foreign('correspondence_id')->references('id')
                 ->on('correspondences')->onDelete('cascade');

                 $table->unsignedBiginteger('user_id')->unsigned();
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
        Schema::dropIfExists('correspondence_distribution_members');
    }
};
