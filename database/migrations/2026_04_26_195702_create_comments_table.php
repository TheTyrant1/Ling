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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('status_id')->default(1);
            $table->text('message');
            $table->timestamps();

            $table->softDeletes();

            $table->index('post_id', 'comments_post_idx');
            $table->index('user_id', 'comments_user_idx');
            $table->index('parent_id', 'comments_parent_idx');
            $table->index('status_id', 'comments_status_idx');

            $table->foreign('post_id', 'comments_post_fk')
                ->on('posts')
                ->references('id')
                ->onDelete('cascade');
            $table->foreign('user_id', 'comments_user_fk')
                ->on('users')
                ->references('id');
            $table->foreign('parent_id', 'comments_parent_fk')
                ->on('comments')
                ->references('id');
            $table->foreign('status_id', 'comments_status_fk')
                ->on('statuses')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
