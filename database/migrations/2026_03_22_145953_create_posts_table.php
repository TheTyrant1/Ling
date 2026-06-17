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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('preview_image')->nullable();
            $table->string('main_image')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('status_id')->default(1);

            $table->timestamps();
            $table->timestamp('admin_updated_at')->nullable();
            $table->timestamp('user_updated_at')->nullable();

            $table->index('user_id', 'post_user_idx');
            $table->index('status_id', 'post_status_idx');

            $table->foreign('user_id', 'post_user_fk')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');

            $table->foreign('status_id', 'post_status_fk')
                ->on('statuses')
                ->references('id');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
