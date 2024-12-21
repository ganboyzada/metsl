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
        Schema::create('punch_list_participants', function (Blueprint $table) {
            $table->id();
			$table->unsignedBiginteger('punch_list_id')->unsigned();
            $table->foreign('punch_list_id')->references('id')
                ->on('punch_lists')->onDelete('cascade');	
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
        Schema::dropIfExists('punch_list_participants');
    }
};
