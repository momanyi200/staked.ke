<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tickets
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()                       // 👈 make it optional
                  ->after('id')
                  ->constrained()
                  ->nullOnDelete();                 // set to NULL if user is deleted
        });

        // Wallets
        Schema::table('wallets', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->constrained()
                  ->nullOnDelete();
        });

        // Wallet Transactions
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('wallet_id')
                  ->constrained()
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
