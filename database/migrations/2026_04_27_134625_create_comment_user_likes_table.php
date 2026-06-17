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
        Schema::create('comment_user_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->unsignedBigInteger('user_id');
            $table->unique(['user_id', 'comment_id']);

            $table->index('comment_id', 'cul_comment_idx');
            $table->index('user_id', 'cul_user_idx');

            $table->foreign('comment_id', 'cul_comment_fk')->on('comments')->references('id')->onDelete('cascade');
            $table->foreign('user_id', 'cul_user_fk')->on('users')->references('id')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_user_likes');
    }
};
