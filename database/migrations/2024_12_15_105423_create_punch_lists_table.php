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
        Schema::create('punch_lists', function (Blueprint $table) {
            $table->id();
			$table->string('number')->nullable()->index();
			$table->string('title')->nullable()->index();
			$table->string('location')->nullable();
			$table->char('cost_impact')->nullable();
			$table->char('priority')->nullable();
			$table->LongText('description')->nullable();
			$table->integer('status')->default(1);
            
            $table->date('date_notified_at')->nullable();
            $table->date('date_resolved_at')->nullable();
            $table->date('due_date')->nullable();

            $table->unsignedBiginteger('responsible_id')->unsigned();
            $table->foreign('responsible_id')->references('id')
                ->on('users')->onDelete('cascade');	
				
            $table->unsignedBiginteger('project_id')->unsigned();
            $table->foreign('project_id')->references('id')
                ->on('projects')->onDelete('cascade');
				
            $table->unsignedBiginteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')
                ->on('users')->onDelete('cascade');	

            $table->unsignedBiginteger('closed_by')->unsigned();
            $table->foreign('closed_by')->references('id')
                ->on('users')->onDelete('cascade');		
				
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('punch_lists');
    }
};
