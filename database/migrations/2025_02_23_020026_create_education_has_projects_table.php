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
        Schema::create('education_has_projects', function (Blueprint $table) {
            $table->unsignedBigInteger('education_id')->index('fk_education_has_projects_education_idx');
            $table->unsignedBigInteger('projects_id')->index('fk_education_has_projects_projects1_idx');
            $table->foreign('education_id')->references('id')->on('education')->onUpdate('no action')->onDelete('no action');
            $table->foreign('projects_id')->references('id')->on('projects')->onUpdate('no action')->onDelete('no action');
            $table->primary(['education_id', 'projects_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_has_projects');
    }
};
