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
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->integer('project_id');
			$table->timestamps();
            // $table->increments('project_id');
          
        });
		DB::unprepared('ALTER TABLE `model_has_permissions` DROP PRIMARY KEY, ADD PRIMARY KEY (  `permission_id` ,  `model_id` , `model_type` , `project_id` )');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_has_permissions', function (Blueprint $table) {
            //
        });
    }
};
