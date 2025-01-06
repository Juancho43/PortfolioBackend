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
        Schema::create('Education', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->date("startDate");
            $table->date("endDate");
            $table->enum('type', ['Formal Education', 'Course']);
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Education');
    }
};
