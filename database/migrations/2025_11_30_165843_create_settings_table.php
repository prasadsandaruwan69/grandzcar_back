<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
 {
     Schema::create('settings', function (Blueprint $table) {
         $table->id();
         $table->string('key');           // fuel_type or model_type
         $table->string('value');         // Petrol, Toyota Camry, etc.
         $table->enum('type', ['fuel', 'model','transmission','drive','exterior_color','interior_grade','exterior_grade','status','condition','vehicle_type']);  // to separate them
         $table->timestamps();

         $table->unique(['type', 'value']); // Prevent duplicates
         $table->index('type');
     });
 }

 public function down(): void
 {
     Schema::dropIfExists('settings');
 }
};