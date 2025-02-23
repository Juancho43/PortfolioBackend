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
        Schema::create('profiles', function (Blueprint $table) {
            $table->integer('idProfile', true);
            $table->string('name');
            $table->string('rol');
            $table->text('description');
            $table->integer('Users_idUsers')->index('fk_profiles_users1_idx');
            $table->timestamps();
            $table->date('delete_at')->nullable();

            $table->primary(['idProfile', 'Users_idUsers']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
