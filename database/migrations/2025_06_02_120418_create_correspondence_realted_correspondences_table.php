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
        Schema::create('correspondence_related_correspondences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('correspondence_id')->unsigned();
            $table->unsignedBiginteger('related_id')->unsigned();

            $table->foreign('correspondence_id')->references('id')
                 ->on('correspondences')->onDelete('cascade');
            $table->foreign('related_id')->references('id')
                ->on('correspondences')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correspondence_realted_correspondences');
    }
};
