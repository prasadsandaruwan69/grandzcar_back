<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');          // e.g. Business Owner
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('text');
            $table->string('image')->nullable();
            $table->string('category');       // business | corporate | fleet | family
            $table->date('date')->nullable(); // optional custom date
            $table->boolean('verified')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};