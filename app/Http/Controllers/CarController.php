<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarBrand;
use App\Models\Section;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        // جلب جميع السيارات
        $cars = Car::all();
    
        // حساب المستحقات المتبقية لكل سيارة بناءً على الكمية المعبأة
        foreach ($cars as $car) {
            // افتراض وجود عمليات تعبئة للسيارة
            $filledQuantity = $car->refuelings()->sum('filled_quantity'); // جمع الكميات المعبأة
            $car->remaining_allowance = $car->monthly_allowance - $filledQuantity; // خصم الكمية المعبأة من المخصص الشهري
        }
    
        $sections = Section::all();
        return view('cars.index', compact('cars', 'sections'));
    }
    

    public function create()
    {
        $brands = CarBrand::all();
        $sections = Section::all();
        return view('cars.create',compact('sections','brands'));
    }

    public function store(Request $request)
    {
        $request->validate([ 
            'name' => 'required|string',
            'fuel_type' => 'required|string',
            'monthly_allowance' => 'required|numeric',
            'section_id' => 'required|exists:sections,id',
            'plate_number' => 'required|string|unique:cars,plate_number',
        ]);

        Car::create($request->all());
        return redirect()->route('cars.index')->with('success', 'تمت إضافة السيارة بنجاح');
    }

    public function show(Car $car)
    {
        $sections = Section::all();
        $refuelings = $car->refuelings;
        return view('cars.show', compact('car','sections','refuelings'));
    }

    public function edit(Car $car)
    {
        $sections = Section::all();
        return view('cars.edit', compact('car','sections'));
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'name' => 'required|string',
            'fuel_type' => 'required|string',
            'monthly_allowance' => 'required|numeric',
            'section_id' => 'required|exists:sections,id',
            'plate_number' => 'required|string|unique:cars,plate_number,'.$car->id,
        ]);

        $car->update($request->all());
        return redirect()->route('cars.index')->with('success', 'تم تحديث بيانات السيارة');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'تم حذف السيارة');
    }
}
