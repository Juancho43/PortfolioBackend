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
            $table->unsignedBigInteger('profiles_id')->index('fk_profiles_has_education_profiles1_idx');
            $table->unsignedBigInteger('education_id')->index('fk_profiles_has_education_education1_idx');
            $table->foreign('education_id')->references('id')->on('education')->onUpdate('no action')->onDelete('no action');
            $table->foreign('profiles_id')->references('id')->on('profiles')->onUpdate('no action')->onDelete('no action');
            $table->primary(['profiles_id', 'education_id']);
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
