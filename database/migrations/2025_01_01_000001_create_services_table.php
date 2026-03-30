<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('description');
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->json('technologies')->nullable();
            $table->json('features')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('pricing_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->enum('billing_cycle', ['one-time', 'monthly', 'yearly'])->default('one-time');
            $table->json('features')->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_packages');
        Schema::dropIfExists('services');
    }
};
