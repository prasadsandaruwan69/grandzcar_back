<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SettingController extends Controller
{
    // Get all fuel types
    public function fuels()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::fuel()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch fuel types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all models
    public function models()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::model()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch models',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function vehicle_type()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::vehicle_type()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch vehicle types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all transmission types
    public function transmission()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::transmission()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch transmission types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all drive types
    public function drive()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::drive()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch drive types',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all exterior colors
    public function exterior_color()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::exterior_color()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch exterior colors',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all interior grades
    public function interior_grade()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::interior_grade()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch interior grades',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all exterior grades
    public function exterior_grade()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::exterior_grade()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch exterior grades',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all status values
    public function status()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::status()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch status values',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get all condition values
    public function condition()
    {
        try {
            return response()->json([
                'success' => true,
                'data' => Setting::condition()->orderBy('value')->get()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch condition values',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Add new (fuel or model)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|string|max:100',
            'type'  => 'required|in:fuel,model,exterior_color,vehicle_type,transmission,body_style,drive,interior_grade,exterior_grade,status,condition'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $item = Setting::create([
                'key'   => $request->type . '_type',
                'value' => $request->value,
                'type'  => $request->type
            ]);

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->type) . ' added successfully!',
                'data'    => $item
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create setting',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Update
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'value' => 'required|string|max:100',
            'type'  => 'required|in:fuel,model,exterior_color,vehicle_type,transmission,body_style,drive,interior_grade,exterior_grade,status,condition'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $setting = Setting::findOrFail($id);

            $setting->update([
                'value' => $request->value,
                'type'  => $request->type,
                'key'   => $request->type . '_type',
            ]);

            return response()->json([
                'success' => true,
                'message' => ucfirst($request->type) . ' updated successfully!',
                'data'    => $setting
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Setting not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update setting',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Delete
    public function destroy($id)
    {
        try {
            $setting = Setting::findOrFail($id);
            $name = $setting->value;
            $setting->delete();

            return response()->json([
                'success' => true,
                'message' => "$name deleted successfully"
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Setting not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete setting',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}