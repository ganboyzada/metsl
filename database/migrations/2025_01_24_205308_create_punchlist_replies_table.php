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
        Schema::create('punchlist_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('punch_list_id')->unsigned();
            $table->foreign('punch_list_id')->references('id')
                ->on('punch_lists')->onDelete('cascade');	
            $table->string('title')->nullable();
            $table->text('description')->nullable();		    
			$table->string('file')->nullable();	
            $table->date('created_date')->nullable();

            $table->unsignedBiginteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punchlist_replies');
    }
};
