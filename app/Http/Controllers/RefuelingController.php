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

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        if ($request->filled('tank_id')) {
            $query->where('tank_id', $request->tank_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $refuelings = $query->with(['car', 'tank'])->paginate(10); // عرض 10 عناصر في كل صفحة
        $cars = Car::all();
        $tanks = Tank::all();

        return view('refuelings.index', compact('refuelings', 'cars', 'tanks'));
    }



    public function create()
    {
        $cars = Car::all();
        $tanks = Tank::all();
        return view('refuelings.create', compact('cars', 'tanks'));
    }

    public function store(Request $request)
    {

        $request->merge([
            'date' => $request->input('date') ?? now()->toDateString()
        ]);

        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'tank_id' => 'required|exists:tanks,id',
            'filled_quantity' => 'required|numeric|min:1',
            'date' => 'date',
        ]);

        $car = Car::findOrFail($request->car_id);

        if ($car->monthly_allowance <= 0) {
            return back()->with('error', 'تم الوصول للمستحقات الخاصة بالسيارة ولا يمكن إضافة تعبئة جديدة.');
        }

        $tank = Tank::findOrFail($request->tank_id);
        if ($request->filled_quantity > $tank->remaining_quantity) {
            return back()->with('error', 'الكمية المعبأة أكبر من الكمية المتبقية في الخزان');
        }

        if ($car->restDues >= $request->filled_quantity) {
            $car->restDues -= $request->filled_quantity;
            $car->save();
        } else {
            return back()->with('error', 'المستحقات الشهرية للسيارة غير كافية لإتمام عملية التعبئة')->with('car_remaining_allowance', $car->restDues);
        }

        Refueling::create($request->all());

        $tank->remaining_quantity -= $request->filled_quantity;
        $tank->save();

        return redirect()->route('refuelings.index')
            ->with('success', 'تمت إضافة التعبئة بنجاح')
            ->with('tank_remaining_quantity', $tank->remaining_quantity)
            ->with('car_remaining_allowance', $car->monthly_allowance); // إرسال المستحقات المتبقية
    }


    public function edit(Refueling $refueling)
    {
        $cars = Car::all();
        $tanks = Tank::all();
        return view('refuelings.edit', compact('refueling', 'cars', 'tanks'));
    }


    public function update(Request $request, Refueling $refueling)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'tank_id' => 'required|exists:tanks,id',
            'filled_quantity' => 'required|numeric|min:1',
            'date' => 'required|date',
        ]);

        $refueling->update([
            'car_id' => $request->car_id,
            'tank_id' => $request->tank_id,
            'filled_quantity' => $request->filled_quantity,
            'date' => $request->date,
        ]);

        return redirect()->route('refuelings.index')->with('success', 'تم تحديث عملية التعبئة بنجاح');
    }



    public function destroy(Refueling $refueling)
    {
        $tank = Tank::find($refueling->tank_id);

        if ($tank) {
            $tank->remaining_quantity += $refueling->filled_quantity;
            $tank->save();
        }

        $refueling->delete();

        return redirect()->route('refuelings.index')->with('success', 'تم حذف عملية التعبئة وتمت إعادة الكمية إلى الخزان');
    }

}
