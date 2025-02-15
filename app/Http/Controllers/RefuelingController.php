<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Refueling;
use App\Models\Tank;
use Illuminate\Http\Request;

class RefuelingController extends Controller
{
    public function index(Request $request)
    {
        $query = Refueling::query();
    
        // فلترة حسب السيارة
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }
    
        // فلترة حسب الخزان
        if ($request->filled('tank_id')) {
            $query->where('tank_id', $request->tank_id);
        }
    
        // فلترة حسب التاريخ
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }
    
        $refuelings = $query->with(['car', 'tank'])->get();
        $cars = Car::all(); // جلب جميع السيارات لتعبئة القائمة المنسدلة
        $tanks = Tank::all(); // جلب جميع الخزانات لتعبئة القائمة المنسدلة
    
        return view('refuelings.index', compact('refuelings', 'cars', 'tanks'));
    }
    

    public function create()
    {
        $cars = Car::all();
        $tanks = Tank::all();
        return view('refuelings.create',compact('cars','tanks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'tank_id' => 'required|exists:tanks,id',
            'filled_quantity' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);
    
        // الحصول على السيارة المختارة
        $car = Car::findOrFail($request->car_id);
    
        // تحقق من الوصول إلى المستحقات الشهرية
        if ($car->monthly_allowance <= 0) {
            return back()->with('error', 'تم الوصول للمستحقات الخاصة بالسيارة ولا يمكن إضافة تعبئة جديدة.');
        }
    
        // التأكد من أن الكمية المعبأة لا تتجاوز الكمية المتبقية في الخزان
        $tank = Tank::findOrFail($request->tank_id);
        if ($request->filled_quantity > $tank->remaining_quantity) {
            return back()->with('error', 'الكمية المعبأة أكبر من الكمية المتبقية في الخزان');
        }
    
        // خصم الكمية المعبأة من المستحقات الشهرية للسيارة
        if ($car->monthly_allowance >= $request->filled_quantity) {
            $car->monthly_allowance -= $request->filled_quantity;
            $car->save();
        } else {
            return back()->with('error', 'المستحقات الشهرية للسيارة غير كافية لإتمام عملية التعبئة')->with('car_remaining_allowance', $car->monthly_allowance);
        }
    
        // إنشاء عملية التعبئة
        Refueling::create($request->all());
    
        // تحديث الكمية المتبقية في الخزان
        $tank->remaining_quantity -= $request->filled_quantity;
        $tank->save();
    
        // إرسال الكمية المتبقية في السيارة إلى الصفحة باستخدام الـ session
        return redirect()->route('refuelings.index')
                         ->with('success', 'تمت إضافة التعبئة بنجاح')
                         ->with('tank_remaining_quantity', $tank->remaining_quantity)
                         ->with('car_remaining_allowance', $car->monthly_allowance); // إرسال المستحقات المتبقية
    }
    
    
    
    
    
    

    public function destroy(Refueling $refueling)
    {
        $refueling->delete();
        return redirect()->route('refuelings.index')->with('success', 'تم حذف عملية التعبئة');
    }
}
