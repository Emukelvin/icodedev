<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description');
            $table->string('client_name')->nullable();
            $table->string('category');
            $table->json('technologies')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('images')->nullable();
            $table->string('live_url')->nullable();
            $table->text('client_feedback')->nullable();
            $table->integer('client_rating')->nullable();
            $table->date('completion_date')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_position')->nullable();
            $table->string('client_company')->nullable();
            $table->string('client_avatar')->nullable();
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('client_logos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->string('url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_logos');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('portfolios');
    }
};
