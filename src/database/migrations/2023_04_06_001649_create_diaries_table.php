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
        Schema::create('diaries', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->foreignId('user_id')
                ->comment('uses.id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('main_category_id')
                ->comment('categories.id')
                ->constrained('categories', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('sub_category_id')
                ->comment('categories.id')
                ->nullable()
                ->constrained('categories', 'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('title', 255);
            $table->text('content')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diaries');
    }
};
