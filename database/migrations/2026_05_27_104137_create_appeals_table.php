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
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('type_id')->constrained('appeal_types');

            $table->foreignId('status_id')->constrained('appeal_statuses');

            $table->string('user_message');
            $table->string('admin_message')->nullable();

            $table->timestamps();
            $table->timestamp('admin_updated_at')->nullable();
            $table->timestamp('user_updated_at')->nullable();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};
