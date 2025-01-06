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
        Schema::create('proyect_tags', function (Blueprint $table) {
            

            $table->id();
            $table->unsignedBigInteger('proyect_id');
            $table->unsignedBigInteger('tags_id');
            $table->timestamps();
    
            $table->foreign('proyect_id')->references('id')->on('proyects')->onDelete('cascade');
            $table->foreign('tags_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyect_tags');
    }
};