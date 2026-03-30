<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->string('project_type')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->enum('status', ['new', 'read', 'replied', 'archived'])->default('new');
            $table->timestamps();
        });

        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('service_type');
            $table->text('project_description');
            $table->json('features')->nullable();
            $table->decimal('estimated_budget', 12, 2)->nullable();
            $table->string('timeline')->nullable();
            $table->enum('status', ['new', 'reviewed', 'quoted', 'accepted', 'rejected'])->default('new');
            $table->decimal('quoted_price', 12, 2)->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type');
            $table->string('description');
            $table->nullableMorphs('subject');
            $table->json('properties')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('file_path');
            $table->string('file_type');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('disk')->default('public');
            $table->timestamps();
        });

        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->string('email')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referred_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('code')->unique();
            $table->string('referred_email')->nullable();
            $table->enum('status', ['pending', 'registered', 'converted', 'paid'])->default('pending');
            $table->decimal('commission', 12, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('media');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('quote_requests');
        Schema::dropIfExists('contact_submissions');
        Schema::dropIfExists('pages');
    }
};
