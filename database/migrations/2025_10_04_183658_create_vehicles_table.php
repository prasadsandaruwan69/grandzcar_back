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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            
            // Auction / Purchase info
            $table->string('auction_number')->nullable();
       
            $table->string('lot_number')->nullable();
            $table->string('auction_system')->nullable();
            $table->date('auction_date')->nullable();
            $table->decimal('auction_price', 15, 2)->nullable();

            // Basic Vehicle info
            $table->string('stock_number')->unique();
            $table->string('vehicle_title')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('body_type')->nullable();
            $table->string('make');
            $table->string('model');
            $table->string('model_code')->nullable();
            $table->string('grade')->nullable();
            $table->string('chassis_no')->nullable();
            $table->year('manufacture_year')->nullable();
            $table->year('registration_year')->nullable();

            // Dimensions & Specs
            $table->integer('mileage')->nullable();
            $table->integer('engine_cc')->nullable();
            $table->decimal('engine_capacity', 8,2)->nullable();
            $table->string('engine_model')->nullable();
            $table->integer('seating_capacity')->nullable();
            $table->string('hs_code')->nullable();
            $table->decimal('height', 8,2)->nullable();
            $table->decimal('length', 8,2)->nullable();
            $table->decimal('width', 8,2)->nullable();
            $table->decimal('loading_capacity', 8,2)->nullable();
            $table->decimal('weight', 8,2)->nullable();
            $table->integer('doors')->nullable();
            $table->string('m3')->nullable();

            // Transmission / Fuel / Drive
            $table->string('transmission')->nullable();
            $table->string('fuel')->nullable();
            $table->string('drive')->nullable(); // Right / Left hand
            $table->string('exterior_color')->nullable();
            $table->string('interior_grade')->nullable();
            $table->string('exterior_grade')->nullable();
            // $table->boolean('is_4wd')->default(false);

            // Media
            $table->string('video_url')->nullable();

            // Stock status
            $table->string('status')->default('Now On Sale');
            // $table->boolean('display')->default(true);
            // $table->boolean('genuine_stock')->default(false);

            // Pricing
            $table->decimal('fob_price', 15,2)->nullable();
            $table->string('stock_location')->nullable();
            $table->string('condition')->nullable(); // Accident, Damaged, Salvaged, None
            $table->string('sales_person')->nullable();

            // Remarks & extra notes
            $table->text('remarks')->nullable();

            // JSON fields for checkboxes and options
            $table->json('maintenance_points')->nullable();
            $table->json('mechanical_results')->nullable();
            $table->json('other_options')->nullable();
            $table->json('accessories_options')->nullable();

            // JSON for image paths
            $table->json('images')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};