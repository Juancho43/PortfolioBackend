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
        Schema::table('education_has_projects', function (Blueprint $table) {
            $table->foreign(['Education_idEducation'], 'fk_Education_has_Projects_Education')->references(['idEducation'])->on('education')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['Projects_idProjects'], 'fk_Education_has_Projects_Projects1')->references(['idProjects'])->on('projects')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_has_projects', function (Blueprint $table) {
            $table->dropForeign('fk_Education_has_Projects_Education');
            $table->dropForeign('fk_Education_has_Projects_Projects1');
        });
    }
};
