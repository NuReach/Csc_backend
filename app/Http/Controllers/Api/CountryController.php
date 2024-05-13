<?php

namespace App\Http\Controllers\API;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return response()->json(['message' => 'Countries retrieved successfully', 'data' => $countries]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ct_name' => 'required|string',
            'status' => 'nullable|string',
            'ct_link' => 'nullable|string',
        ]);

        $country = Country::create($validatedData);

        return response()->json(['message' => 'Country created successfully', 'data' => $country], 201);
    }
    public function show($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        return response()->json(['message' => 'Country retrieved successfully', 'data' => $country]);
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'ct_name' => 'required|string',
            'status' => 'nullable|string',
            'ct_link' => 'nullable|string',
        ]);

        $country = Country::find($id);
        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $country->update($validatedData);

        return response()->json(['message' => 'Country updated successfully', 'data' => $country], 200);
    }
    public function destroy($id)
    {
        $country = Country::find($id);
        if (!$country) {
            return response()->json(['message' => 'Country not found'], 404);
        }

        $country->delete();
        return response()->json(['message' => 'Country deleted successfully'], 204);
    }
}
