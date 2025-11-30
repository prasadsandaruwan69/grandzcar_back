<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
      use HasFactory;
 protected $fillable = [
        'auction_number', 'lot_number', 'auction_system', 'auction_date', 'auction_price',
        'stock_number', 'vehicle_title', 'vehicle_type', 'body_type', 'make', 'model',
        'model_code', 'grade', 'chassis_no', 'manufacture_year', 'registration_year',
        'mileage', 'engine_cc', 'engine_capacity', 'engine_model', 'seating_capacity',
        'hs_code', 'height', 'length', 'width', 'loading_capacity', 'weight', 'doors', 'm3',
        'transmission', 'fuel', 'drive', 'exterior_color', 'interior_grade', 'exterior_grade',
        'is_4wd', 'video_url', 'status', 'display', 'genuine_stock', 'fob_price',
        'stock_location', 'condition', 'sales_person', 'remarks',
        'maintenance_points', 'mechanical_results', 'other_options', 'accessories_options',
        'images',
    ];

    protected $casts = [
        'maintenance_points' => 'array',
        'mechanical_results' => 'array',
        'other_options' => 'array',
        'accessories_options' => 'array',
        'images' => 'array',
        'is_4wd' => 'boolean',
        'display' => 'boolean',
        'genuine_stock' => 'boolean',
    ];
}
