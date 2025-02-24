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
            $table->unsignedBigInteger('profile_id')->index('fk_profiles_has_links_profiles1_idx');
            $table->unsignedBigInteger('link_id')->index('fk_profiles_has_links_links1_idx');
            $table->foreign('link_id')->references('id')->on('links')->onUpdate('no action')->onDelete('no action');
            $table->foreign('profile_id')->references('id')->on('profiles')->onUpdate('no action')->onDelete('no action');
            $table->primary(['profile_id', 'link_id']);
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
