<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('status', ['pending', 'in_progress', 'review', 'completed', 'cancelled'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->decimal('budget', 12, 2)->nullable();
            $table->decimal('total_paid', 12, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->date('completed_at')->nullable();
            $table->integer('progress')->default(0);
            $table->json('technologies')->nullable();
            $table->string('live_url')->nullable();
            $table->string('repository_url')->nullable();
            $table->boolean('is_portfolio')->default(false);
            $table->timestamps();
        });

        Schema::create('project_developers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('developer');
            $table->timestamps();
            $table->unique(['project_id', 'user_id']);
        });

        Schema::create('project_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'review', 'completed'])->nullable();
            $table->integer('progress_percentage')->nullable();
            $table->timestamps();
        });

        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->text('description')->nullable();
            $table->boolean('is_deliverable')->default(false);
            $table->timestamps();
        });

        Schema::create('project_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('project_comments')->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_comments');
        Schema::dropIfExists('project_files');
        Schema::dropIfExists('project_updates');
        Schema::dropIfExists('project_developers');
        Schema::dropIfExists('projects');
    }
};
