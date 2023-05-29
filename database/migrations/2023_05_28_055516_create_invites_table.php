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
        Schema::create('invites', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('owner')->nullable();
            $table->string('event')->nullable();
            $table->string('dateType')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->text('description')->nullable();
            $table->string('ip')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invites');
    }
};
