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
        Schema::create('post_user_saves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->string('ip')->nullable();

            $table->unique(['post_id', 'user_id', 'ip']);

            $table->index('post_id', 'pus_post_idx');
            $table->index('user_id', 'pus_user_idx');

            $table->foreign('post_id', 'pus_post_fk')->on('posts')->references('id')->onDelete('cascade');
            $table->foreign('user_id', 'pus_user_fk')->on('users')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_user_saves');
    }
};
