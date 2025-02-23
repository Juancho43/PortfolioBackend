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
        Schema::table('projects_has_tags', function (Blueprint $table) {
            $table->foreign(['Projects_idProjects'], 'fk_Projects_has_Tags_Projects1')->references(['idProjects'])->on('projects')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['Tags_idTags'], 'fk_Projects_has_Tags_Tags1')->references(['idTags'])->on('tags')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects_has_tags', function (Blueprint $table) {
            $table->dropForeign('fk_Projects_has_Tags_Projects1');
            $table->dropForeign('fk_Projects_has_Tags_Tags1');
        });
    }
};
