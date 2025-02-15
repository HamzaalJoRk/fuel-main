<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Section;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::all();
        return view('drivers.index', compact('drivers'));
    }
    
    public function create()
    {
        $sections = Section::all();
        $cars = Car::all();
        return view('drivers.create',compact('sections','cars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'section_id' => 'required|exists:sections,id',
            'name' => 'required|string',
            'surname' => 'required|string',
            'father_name' => 'required|string',
            'phone' => 'required|string',
        ]);

        Driver::create($request->all());
        return redirect()->route('drivers.index')->with('success', 'تمت إضافة السائق بنجاح');
    }

    public function show(Driver $driver)
    {
        return view('drivers.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        $sections = Section::all();
        $cars = Car::all();
        return view('drivers.edit', compact('driver','sections','cars'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'section_id' => 'required|exists:sections,id',
            'name' => 'required|string',
            'surname' => 'required|string',
            'father_name' => 'required|string',
            'department' => 'required|string',
        ]);

        $driver->update($request->all());
        return redirect()->route('drivers.index')->with('success', 'تم تحديث بيانات السائق');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return redirect()->route('drivers.index')->with('success', 'تم حذف السائق');
    }
}
