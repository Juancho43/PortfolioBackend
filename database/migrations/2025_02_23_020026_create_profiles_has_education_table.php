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
        Schema::create('profiles_has_education', function (Blueprint $table) {
            $table->integer('Profiles_idProfile')->index('fk_profiles_has_education_profiles1_idx');
            $table->integer('Education_idEducation');
            $table->integer('Education_Profiles_idProfile');

            $table->index(['Education_idEducation', 'Education_Profiles_idProfile'], 'fk_profiles_has_education_education1_idx');
            $table->primary(['Profiles_idProfile', 'Education_idEducation', 'Education_Profiles_idProfile']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles_has_education');
    }
};
