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
            $table->unsignedBigInteger('project_id')->index('fk_projects_has_links_projects1_idx');
            $table->unsignedBigInteger('link_id')->index('fk_projects_has_links_links1_idx');
            $table->foreign('link_id')->references('id')->on('links')->onUpdate('no action')->onDelete('no action');
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('no action')->onDelete('no action');
            $table->primary(['project_id', 'link_id']);
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
