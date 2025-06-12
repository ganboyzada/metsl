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
        Schema::table('projects_users', function (Blueprint $table) {
           

            $table->unsignedBigInteger('company_id')->nullable(); // Adjust placement with `after`
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');

            $table->string('office_phone')->nullable();
            $table->string('specialty')->nullable(); 
            $table->string('type')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects_users', function (Blueprint $table) {
            //
        });
    }
};
