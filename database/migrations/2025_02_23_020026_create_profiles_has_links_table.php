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
        Schema::create('profiles_has_links', function (Blueprint $table) {
            $table->integer('Profiles_idProfile')->index('fk_profiles_has_links_profiles1_idx');
            $table->integer('Links_idLinks')->index('fk_profiles_has_links_links1_idx');

            $table->primary(['Profiles_idProfile', 'Links_idLinks']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles_has_links');
    }
};
