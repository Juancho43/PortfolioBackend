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
            $table->integer('Works_idWorks')->index('fk_works_has_tags_works1_idx');
            $table->integer('Tags_idTags')->index('fk_works_has_tags_tags1_idx');

            $table->primary(['Works_idWorks', 'Tags_idTags']);
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
