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
        Schema::table('profiles_has_links', function (Blueprint $table) {
            $table->foreign(['Links_idLinks'], 'fk_Profiles_has_Links_Links1')->references(['idLinks'])->on('links')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['Profiles_idProfile'], 'fk_Profiles_has_Links_Profiles1')->references(['idProfile'])->on('profiles')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles_has_links', function (Blueprint $table) {
            $table->dropForeign('fk_Profiles_has_Links_Links1');
            $table->dropForeign('fk_Profiles_has_Links_Profiles1');
        });
    }
};
