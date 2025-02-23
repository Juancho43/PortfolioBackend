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
        Schema::table('profiles_has_works', function (Blueprint $table) {
            $table->foreign(['Profiles_idProfile'], 'fk_Profiles_has_Works_Profiles1')->references(['idProfile'])->on('profiles')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['Works_idWorks'], 'fk_Profiles_has_Works_Works1')->references(['idWorks'])->on('works')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles_has_works', function (Blueprint $table) {
            $table->dropForeign('fk_Profiles_has_Works_Profiles1');
            $table->dropForeign('fk_Profiles_has_Works_Works1');
        });
    }
};
