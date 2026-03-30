<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add invoice_id and proof_of_payment to payments
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('invoice_id')->nullable()->after('project_id')->constrained()->nullOnDelete();
            $table->string('proof_of_payment')->nullable()->after('description');
            $table->text('admin_notes')->nullable()->after('proof_of_payment');
        });

        // Expand gateway enum - drop and recreate as string
        Schema::table('payments', function (Blueprint $table) {
            $table->string('gateway', 30)->default('paystack')->change();
        });

        // Crypto wallets managed by admin
        Schema::create('crypto_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Bitcoin, Ethereum, USDT
            $table->string('symbol', 10); // BTC, ETH, USDT
            $table->string('network')->nullable(); // e.g. ERC-20, TRC-20, BEP-20
            $table->string('wallet_address');
            $table->string('icon')->nullable(); // Font Awesome class or image path
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Add user_id and status to testimonials so clients can submit
        Schema::table('testimonials', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['invoice_id']);
            $table->dropColumn(['invoice_id', 'proof_of_payment', 'admin_notes']);
        });

        Schema::dropIfExists('crypto_wallets');

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'status']);
        });
    }
};
