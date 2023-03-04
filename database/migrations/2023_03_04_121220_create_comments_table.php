<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->foreignId('user_id')
                ->nullable() //null бола алады
                ->constrained() // связка жасауга комектеседи
                ->nullOnDelete(); // user удалить етилип калса сонын айдиы null боп калады
            $table->foreignId('post_id')
                ->constrained() // связка жасауга комектеседи форинки жасауга
                ->cascadeOnDelete(); // post ошетин болса сол посттын коменттарилары ошип калады (постпен бирге)
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
