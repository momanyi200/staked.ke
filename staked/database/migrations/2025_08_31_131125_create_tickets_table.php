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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->date('date');
            $table->decimal('total_stake', 10, 2);
            $table->decimal('total_odds', 8, 2)->default(1);
            $table->decimal('total_return', 10, 2)->nullable(); // potential or final
            $table->enum('status', ['pending', 'win', 'lost'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
