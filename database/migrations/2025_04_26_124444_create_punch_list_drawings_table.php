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
        Schema::create('punch_list_drawings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('punchList_id')->unsigned();
            $table->foreign('punchList_id')->references('id')
                 ->on('punch_lists')->onDelete('cascade');

            $table->unsignedBiginteger('drawing_id')->unsigned()->nullable();
            $table->foreign('drawing_id')->references('id')
                ->on('project_drawings')->onDelete('cascade');
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punch_list_drawings');
    }
};
