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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->longText('description')->nullable();
            $table->integer('status')->default(1);
            $table->string('priority')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('file')->nullable();
            $table->date('created_date')->nullable();
            $table->unsignedBiginteger('group_id')->unsigned();
            $table->foreign('group_id')->references('id')
                 ->on('groups')->onDelete('cascade');

            $table->unsignedBiginteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('cascade');
            $table->unsignedBiginteger('project_id')->unsigned();
            $table->foreign('project_id')->references('id')
                    ->on('projects')->onDelete('cascade');     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
