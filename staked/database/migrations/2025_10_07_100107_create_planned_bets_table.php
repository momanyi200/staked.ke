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
        Schema::create('planned_bets', function (Blueprint $table) {
            $table->id();

            // Teams
            $table->foreignId('home_team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('away_team_id')->constrained('teams')->onDelete('cascade');

            // Optional: user if multi-user system
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            // Bet details
            $table->string('prediction')->nullable(); // e.g. Home Win, Over 2.5
            $table->decimal('odd', 8, 2)->nullable(); // ✅ odds added here
            $table->text('notes')->nullable();
            $table->dateTime('match_date')->nullable();

            // Status
            $table->enum('status', ['pending', 'decided', 'discarded', 'moved','expired'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planned_bets');
    }
};
