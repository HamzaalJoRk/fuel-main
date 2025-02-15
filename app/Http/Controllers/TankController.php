<?php

namespace App\Http\Controllers;

use App\Models\Tank;
use Illuminate\Http\Request;

class TankController extends Controller
{
    public function index()
    {
        $tanks = Tank::all();
        return view('tanks.index', compact('tanks'));
    }

    public function create()
    {
        return view('tanks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:tanks,name',
            'fuel_type' => 'required|string',
            'total_capacity' => 'required|numeric|min:1',
        ]);

        $name = $request->input('name');
        $fuel_type = $request->input('fuel_type');
        $total_capacity = $request->input('total_capacity');

        Tank::create([
            'name' => $name,
            'fuel_type' => $fuel_type,
            'remaining_quantity' => $total_capacity,
            'total_capacity' => $total_capacity,
        ]);

        return redirect()->route('tanks.index')->with('success', 'تمت إضافة الخزان بنجاح');
    }


    public function show(Tank $tank)
    {
        return view('tanks.show', compact('tank'));
    }

    public function edit(Tank $tank)
    {
        return view('tanks.edit', compact('tank'));
    }

    public function update(Request $request, Tank $tank)
    {
        $request->validate([
            'name' => 'string|unique:tanks,name,'.$tank->id,
            'fuel_type' => 'string',
            'total_capacity' => 'numeric|min:1',
        ]);

        $tank->update($request->all());
        return redirect()->route('tanks.index')->with('success', 'تم تحديث بيانات الخزان');
    }

    public function destroy(Tank $tank)
    {
        $tank->delete();
        return redirect()->route('tanks.index')->with('success', 'تم حذف الخزان');
    }
}
