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
        Schema::create('education_has_links', function (Blueprint $table) {
            $table->unsignedBigInteger('education_id')->index('fk_works_has_links_education3_idx');
            $table->unsignedBigInteger('link_id')->index('fk_works_has_links_links1_idx');
            $table->foreign('link_id')->references('id')->on('links')->onUpdate('no action')->onDelete('no action');
            $table->foreign('education_id')->references('id')->on('education')->onUpdate('no action')->onDelete('no action');
            $table->primary(['education_id', 'link_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education_has_links');
    }
};
