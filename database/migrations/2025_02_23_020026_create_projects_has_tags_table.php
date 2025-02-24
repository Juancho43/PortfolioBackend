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
            $table->unsignedBigInteger('projects_id')->index('fk_projects_has_tags_projects1_idx');
            $table->unsignedBigInteger('tags_id')->index('fk_projects_has_tags_tags1_idx');
            $table->foreign('projects_id')->references('id')->on('projects')->onUpdate('no action')->onDelete('no action');
            $table->foreign('tags_id')->references('id')->on('tags')->onUpdate('no action')->onDelete('no action');
            $table->primary(['projects_id', 'tags_id']);
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
