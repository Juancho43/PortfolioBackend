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
        Schema::table('education_has_tags', function (Blueprint $table) {
            $table->foreign(['Education_idEducation'], 'fk_Education_has_Tags_Education1')->references(['idEducation'])->on('education')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['Tags_idTags'], 'fk_Education_has_Tags_Tags1')->references(['idTags'])->on('tags')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('education_has_tags', function (Blueprint $table) {
            $table->dropForeign('fk_Education_has_Tags_Education1');
            $table->dropForeign('fk_Education_has_Tags_Tags1');
        });
    }
};
