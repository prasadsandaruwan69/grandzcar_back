<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        return response()->json(Vehicle::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'stock_number' => 'required|unique:vehicles',
        
            'make' => 'required',
            'model' => 'required',
            'auction_price' => 'nullable|numeric',
            'fob_price' => 'nullable|numeric',
            'mileage' => 'nullable|integer',
            'engine_cc' => 'nullable|integer',
            'engine_capacity' => 'nullable|numeric',
            'seating_capacity' => 'nullable|integer',
            'height' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'loading_capacity' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'doors' => 'nullable|integer',
            // 'is_4wd' => 'nullable|integer',
            // 'display' => 'nullable|integer',
            // 'genuine_stock' => 'nullable|integer',
            'images.*' => 'image|mimes:jpeg,png,bmp|max:5120', // Max 5MB per image
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Decode JSON strings to arrays
        if ($request->has('maintenance_points')) {
            $data['maintenance_points'] = json_decode($request->input('maintenance_points'), true);
        }
        if ($request->has('mechanical_results')) {
            $data['mechanical_results'] = json_decode($request->input('mechanical_results'), true);
        }
        if ($request->has('other_options')) {
            $data['other_options'] = json_decode($request->input('other_options'), true);
        }
        if ($request->has('accessories_options')) {
            $data['accessories_options'] = json_decode($request->input('accessories_options'), true);
        }

        // Create vehicle without images first
        $vehicle = Vehicle::create($data);

        // Handle images
        $addWatermark = $request->boolean('addWatermark');
        $paths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // TODO: If $addWatermark is true, use Intervention\Image or similar to add watermark
                // For now, assuming no watermark implementation; just store original
                $path = $image->store("vehicles/{$vehicle->id}", 'public');
                $paths[] = Storage::url($path);
            }
            $vehicle->images = $paths;
            $vehicle->save();
        }

        return response()->json($vehicle, 201);
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return response()->json($vehicle);
    }

    public function update(Request $request, $id)
    {
        

        $vehicle = Vehicle::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'stock_number' => 'required|unique:vehicles,stock_number,' . $id,
             
            'make' => 'required',
            'model' => 'required',
            'auction_price' => 'nullable|numeric',
            'fob_price' => 'nullable|numeric',
            'mileage' => 'nullable|integer',
            'engine_cc' => 'nullable|integer',
            'engine_capacity' => 'nullable|numeric',
            'seating_capacity' => 'nullable|integer',
            'height' => 'nullable|numeric',
            'length' => 'nullable|numeric',
            'width' => 'nullable|numeric',
            'loading_capacity' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'doors' => 'nullable|integer',
            // 'is_4wd' => 'nullable|integer',
            // 'display' => 'nullable|integer',
            // 'genuine_stock' => 'nullable|integer',
            'images.*' => 'image|mimes:jpeg,png,bmp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Decode JSON strings to arrays
        if ($request->has('maintenance_points')) {
            $data['maintenance_points'] = json_decode($request->input('maintenance_points'), true);
        }
        if ($request->has('mechanical_results')) {
            $data['mechanical_results'] = json_decode($request->input('mechanical_results'), true);
        }
        if ($request->has('other_options')) {
            $data['other_options'] = json_decode($request->input('other_options'), true);
        }
        if ($request->has('accessories_options')) {
            $data['accessories_options'] = json_decode($request->input('accessories_options'), true);
        }

        $vehicle->update($data);

        // Handle new images (append to existing)
        $addWatermark = $request->boolean('addWatermark');
        $paths = $vehicle->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // TODO: Watermark if needed
                $path = $image->store("vehicles/{$vehicle->id}", 'public');
                $paths[] = Storage::url($path);
            }
            $vehicle->images = $paths;
            $vehicle->save();
        }

        return response()->json($vehicle);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        // Optionally delete associated images from storage
        if ($vehicle->images) {
            foreach ($vehicle->images as $image) {
                Storage::delete(str_replace('/storage/', 'public/', $image));
            }
        }
        $vehicle->delete();
        return response()->json(null, 204);
    }
}