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
        Schema::create('package_sub_folders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBiginteger('package_id')->unsigned();
            $table->foreign('package_id')->references('id')
                    ->on('packages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_sub_folders');
    }
};
