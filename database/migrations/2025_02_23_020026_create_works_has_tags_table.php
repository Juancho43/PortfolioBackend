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
        Schema::create('works_has_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('works_id')->index('fk_works_has_tags_works1_idx');
            $table->unsignedBigInteger('tags_id')->index('fk_works_has_tags_tags1_idx');
            $table->foreign('tags_id')->references('id')->on('tags')->onUpdate('no action')->onDelete('no action');
            $table->foreign('works_id')->references('id')->on('works')->onUpdate('no action')->onDelete('no action');
            $table->primary(['works_id', 'tags_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works_has_tags');
    }
};
