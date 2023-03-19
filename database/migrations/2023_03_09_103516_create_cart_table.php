<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // бул таблица типа посттарды сатып алынган посттарды сактайды
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('post_id')->constrained();
            $table->unsignedInteger('number')->default(1);
            $table->string('color');
            $table->string('status')->default('in_cart');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
