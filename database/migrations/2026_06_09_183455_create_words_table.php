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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->nullable()->constrained()->nullOnDelete();
            $table->string('character');
            $table->string('pinyin');
            $table->string('translation');
            $table->string('emoji')->default('📝');
            $table->string('type')->default('noun');
            $table->integer('hsk_level')->default(1);
            $table->text('example_sentence')->nullable();
            $table->string('example_pinyin')->nullable();
            $table->string('example_translation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
