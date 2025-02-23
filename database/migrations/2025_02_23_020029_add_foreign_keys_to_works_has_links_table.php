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
        Schema::table('works_has_links', function (Blueprint $table) {
            $table->foreign(['Links_idLinks'], 'fk_Works_has_Links_Links1')->references(['idLinks'])->on('links')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['Works_idWorks'], 'fk_Works_has_Links_Works1')->references(['idWorks'])->on('works')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works_has_links', function (Blueprint $table) {
            $table->dropForeign('fk_Works_has_Links_Links1');
            $table->dropForeign('fk_Works_has_Links_Works1');
        });
    }
};
