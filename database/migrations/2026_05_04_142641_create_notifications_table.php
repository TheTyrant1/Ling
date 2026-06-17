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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('from_user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('type');

            $table->foreignId('post_id')
                ->nullable()
                ->constrained('posts')
                ->nullOnDelete();

            $table->foreignId('comment_id')
                ->nullable()
                ->constrained('comments')
                ->nullOnDelete();

            $table->unique(['user_id', 'from_user_id', 'type', 'post_id', 'comment_id']);

            $table->timestamp('read_at')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
