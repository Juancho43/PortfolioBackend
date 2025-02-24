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
            $table->unsignedBigInteger('education_id')->index('fk_education_has_tags_education1_idx');
            $table->unsignedBigInteger('tags_id')->index('fk_education_has_tags_tags1_idx');
            $table->foreign('education_id')->references('id')->on('education')->onUpdate('no action')->onDelete('no action');
            $table->foreign('tags_id')->references('id')->on('tags')->onUpdate('no action')->onDelete('no action');
            $table->primary(['education_id',  'tags_id']);
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
