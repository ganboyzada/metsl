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
        Schema::table('correspondences', function (Blueprint $table) {
            $table->dropForeign(['recieved_from']);
            $table->dropColumn(['recieved_from', 'recieved_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('correspondences', function (Blueprint $table) {
            $table->string('recieved_from')->nullable();
            $table->date('recieved_date')->nullable();

            // Recreate the foreign key constraint
            $table->foreign('recieved_from')->references('id')->on('related_table_name')->onDelete('cascade');
        });
    }
};
