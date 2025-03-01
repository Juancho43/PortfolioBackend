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
            $table->unsignedBigInteger('work_id')->index('fk_works_has_tags_works1_idx');
            $table->unsignedBigInteger('tag_id')->index('fk_works_has_tags_tags1_idx');
            $table->foreign('tag_id')->references('id')->on('tags')->onUpdate('no action')->onDelete('no action');
            $table->foreign('work_id')->references('id')->on('works')->onUpdate('no action')->onDelete('no action');
            $table->primary(['work_id', 'tag_id']);
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
