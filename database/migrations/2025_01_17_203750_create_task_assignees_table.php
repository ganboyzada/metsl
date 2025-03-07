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
        Schema::create('task_assignees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('task_id')->unsigned();
            $table->foreign('task_id')->references('id')
                 ->on('tasks')->onDelete('cascade');

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
        Schema::dropIfExists('task_assignees');
    }
};
