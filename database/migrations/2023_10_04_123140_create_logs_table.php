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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('book_id');
            $table->string('author');
            $table->string('title');
            $table->string('publisher');
            $table->string('genre');
            $table->string('edition');
            $table->text('description')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /*
     $data = $request->validate([
            'author' => ['required'],
            'title' => ['required', 'unique:books,title'],
            'publisher' => ['required'],
            'genre' => ['required'],
            'edition' => ['required', new Enum(Enums::class)],
            'description' => ['sometimes'],
            'file' => ['sometimes', 'file', 'image'],
        ]);
     */

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log');
    }
};
