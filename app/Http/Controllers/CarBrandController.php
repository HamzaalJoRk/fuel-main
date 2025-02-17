<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use Illuminate\Http\Request;

class CarBrandController extends Controller
{
    // عرض جميع العلامات التجارية
    public function index()
    {
        $brands = CarBrand::all();
        return view('car_brands.index', compact('brands'));
    }

    // عرض نموذج إنشاء علامة جديدة
    public function create()
    {
        return view('car_brands.create');
    }

    // حفظ العلامة التجارية الجديدة
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'Brand' => 'required|string|max:255',
        ]);

        CarBrand::create($request->all());

        return redirect()->route('car_brands.index')->with('success', 'تمت إضافة العلامة التجارية بنجاح.');
    }

    // عرض نموذج التعديل
    public function edit(CarBrand $carBrand)
    {
        return view('car_brands.edit', compact('carBrand'));
    }

    // تحديث بيانات العلامة التجارية
    public function update(Request $request, CarBrand $carBrand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'Brand' => 'required|string|max:255',
        ]);

        $carBrand->update($request->all());

        return redirect()->route('car_brands.index')->with('success', 'تم تعديل العلامة التجارية بنجاح.');
    }

    // حذف العلامة التجارية
    public function destroy(CarBrand $carBrand)
    {
        $carBrand->delete();
        return redirect()->route('car_brands.index')->with('success', 'تم حذف العلامة التجارية بنجاح.');
    }
}
