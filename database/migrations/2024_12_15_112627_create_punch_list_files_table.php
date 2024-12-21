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
        Schema::create('punch_list_files', function (Blueprint $table) {
            $table->id();
			$table->unsignedBiginteger('punch_list_id')->unsigned();
            $table->foreign('punch_list_id')->references('id')
                ->on('punch_lists')->onDelete('cascade');	
			$table->string('file')->nullable();	
            $table->string('type')->nullable();
            $table->double('size')->nullable();			
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punch_list_files');
    }
};
