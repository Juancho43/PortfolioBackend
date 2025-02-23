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
        Schema::table('projects_has_links', function (Blueprint $table) {
            $table->foreign(['Links_idLinks'], 'fk_Projects_has_Links_Links1')->references(['idLinks'])->on('links')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['Projects_idProjects'], 'fk_Projects_has_Links_Projects1')->references(['idProjects'])->on('projects')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects_has_links', function (Blueprint $table) {
            $table->dropForeign('fk_Projects_has_Links_Links1');
            $table->dropForeign('fk_Projects_has_Links_Projects1');
        });
    }
};
