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
        Schema::create('projects_has_links', function (Blueprint $table) {
            $table->integer('Projects_idProjects')->index('fk_projects_has_links_projects1_idx');
            $table->integer('Links_idLinks')->index('fk_projects_has_links_links1_idx');

            $table->primary(['Projects_idProjects', 'Links_idLinks']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_has_links');
    }
};
