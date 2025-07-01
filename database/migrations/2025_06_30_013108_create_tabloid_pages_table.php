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
        Schema::create('tabloid_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tabloid_id')->constrained('tabloids')->onDelete('cascade');
            $table->integer('page_number');
            $table->json('data');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabloid_pages');
    }
};
