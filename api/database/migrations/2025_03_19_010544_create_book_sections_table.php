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
        Schema::create('book_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('book_id')->constrained();
            $table->foreignId('parent_id')
                ->constrained()
                ->nullable()
                ->index();
            $table->string('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_sections');
    }
};
