<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    
    protected $fillable = ['key', 'value', 'type'];
    
    // Add these scopes to filter by type
    public function scopeFuel($query)
    {
        return $query->where('type', 'fuel');
    }
    
    public function scopeModel($query)
    {
        return $query->where('type', 'model');
    }

    public function scopevehicle_type($query)
    {
        return $query->where('type', 'vehicle_type');
    }

    public function scopeTransmission($query)
    {
        return $query->where('type', 'transmission');
    }

    public function scopeDrive($query)
    {
        return $query->where('type', 'drive');
    }

    public function scopeExterior_color($query)
    {
        return $query->where('type', 'exterior_color');
    }

    public function scopeInterior_grade($query)
    {
        return $query->where('type', 'interior_grade');
    }

    public function scopeExterior_grade($query)
    {
        return $query->where('type', 'exterior_grade');
    }

    public function scopeStatus($query)
    {
        return $query->where('type', 'status');
    }

    public function scopeCondition($query)
    {
        return $query->where('type', 'condition');
    }
}