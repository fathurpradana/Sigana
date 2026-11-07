<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disaster_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('agency', 150)->nullable();
            $table->string('phone', 30);
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('general_information', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('image')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('mitigations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('disaster_categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('title');
            $table->string('phase', 50);
            $table->text('content');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('disasters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('disaster_categories')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->string('title');
            $table->string('location');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->dateTime('occurred_at');
            $table->string('status', 50)->default('Dilaporkan');
            $table->string('verification_status', 20)->default('Disetujui');
            $table->dateTime('approved_at')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('title');
            $table->text('message');
            $table->string('type', 50)->default('Informasi');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('disasters');
        Schema::dropIfExists('mitigations');
        Schema::dropIfExists('general_information');
        Schema::dropIfExists('emergency_contacts');
        Schema::dropIfExists('disaster_categories');
    }
};