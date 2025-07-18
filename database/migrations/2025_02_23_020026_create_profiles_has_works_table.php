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
        Schema::create('profiles_has_works', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id')->index('fk_profiles_has_works_profiles1_idx');
            $table->unsignedBigInteger('work_id')->index('fk_profiles_has_works_works1_idx');
            $table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('no action')->onDelete('no action');
            $table->foreign('work_id')->references('id')->on('works')->onUpdate('no action')->onDelete('no action');
            $table->primary(['profile_id', 'work_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles_has_works');
    }
};
