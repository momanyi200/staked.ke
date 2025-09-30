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
        Schema::table('teams', function (Blueprint $table) {
            // Drop old unique index on name
            $table->dropUnique('teams_name_unique'); 

            // Add composite unique index on name + country_id
            $table->unique(['name', 'country_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropUnique(['name', 'country_id']);
            $table->unique('name');
        });
    }
};
