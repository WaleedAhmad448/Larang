<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    // الحصول على جميع العقارات
    public function index()
    {
        return Property::all();
    }

    // إضافة عقار جديد
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $property = Property::create($request->all());
        return response()->json($property, 201);
    }

    // الحصول على عقار معين
    public function show($id)
    {
        return Property::findOrFail($id);
    }

    // تحديث عقار
    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->update($request->all());
        return response()->json($property, 200);
    }

    // حذف عقار
    public function destroy($id)
    {
        Property::destroy($id);
        return response()->json(null, 204);
    }
}