<?php

// database/migrations/2025_09_29_000001_add_notes_to_tickets_and_create_journals_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add notes to tickets
        Schema::table('tickets', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('total_odds');
        });

        // Create journals table
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique(); // one entry per day
            $table->foreignId('user_id');
            $table->text('summary')->nullable();   // overall betting day summary
            $table->text('thoughts')->nullable();  // mindset, lessons, reflections
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('notes');
        });

        Schema::dropIfExists('journals');
    }
};

