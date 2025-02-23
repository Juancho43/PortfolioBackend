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
            $table->integer('Education_idEducation')->index('fk_education_has_projects_education_idx');
            $table->integer('Projects_idProjects')->index('fk_education_has_projects_projects1_idx');

            $table->primary(['Education_idEducation', 'Projects_idProjects']);
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
