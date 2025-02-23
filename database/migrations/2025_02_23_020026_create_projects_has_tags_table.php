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
        Schema::create('projects_has_tags', function (Blueprint $table) {
            $table->integer('Projects_idProjects')->index('fk_projects_has_tags_projects1_idx');
            $table->integer('Tags_idTags')->index('fk_projects_has_tags_tags1_idx');

            $table->primary(['Projects_idProjects', 'Tags_idTags']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_has_tags');
    }
};
