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
        Schema::create('bet_guidelines', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['routine', 'rule'])->index(); // routine or rule
            $table->string('title')->nullable(); // short headline or emoji title
            $table->text('description'); // the content
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bet_guidelines');
    }
};
