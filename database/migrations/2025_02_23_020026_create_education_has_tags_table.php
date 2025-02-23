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
        Schema::create('education_has_tags', function (Blueprint $table) {
            $table->integer('Education_idEducation');
            $table->integer('Education_Profiles_idProfile');
            $table->integer('Tags_idTags')->index('fk_education_has_tags_tags1_idx');

            $table->index(['Education_idEducation', 'Education_Profiles_idProfile'], 'fk_education_has_tags_education1_idx');
            $table->primary(['Education_idEducation', 'Education_Profiles_idProfile', 'Tags_idTags']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_has_tags');
    }
};
