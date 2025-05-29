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
        Schema::create('company_work_packages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBiginteger('company_id')->unsigned();
            $table->unsignedBiginteger('work_package_id')->unsigned();

            $table->foreign('company_id')->references('id')
                 ->on('companies')->onDelete('cascade');
            $table->foreign('work_package_id')->references('id')
                ->on('work_packages')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_work_packages');
    }
};
