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
        Schema::create('works_has_links', function (Blueprint $table) {
            $table->integer('Works_idWorks')->index('fk_works_has_links_works1_idx');
            $table->integer('Links_idLinks')->index('fk_works_has_links_links1_idx');

            $table->primary(['Works_idWorks', 'Links_idLinks']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works_has_links');
    }
};
