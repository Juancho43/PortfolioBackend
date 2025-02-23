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
        Schema::table('works_has_tags', function (Blueprint $table) {
            $table->foreign(['Tags_idTags'], 'fk_Works_has_Tags_Tags1')->references(['idTags'])->on('tags')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['Works_idWorks'], 'fk_Works_has_Tags_Works1')->references(['idWorks'])->on('works')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works_has_tags', function (Blueprint $table) {
            $table->dropForeign('fk_Works_has_Tags_Tags1');
            $table->dropForeign('fk_Works_has_Tags_Works1');
        });
    }
};
