<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable();
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->integer('quantity')->default(1);
            $table->string('genre');
            $table->enum('condition', ['new', 'like-new', 'very-good', 'good', 'acceptable']);
            $table->string('cover_image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['available', 'sold'])->default('available');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('books');
    }
};