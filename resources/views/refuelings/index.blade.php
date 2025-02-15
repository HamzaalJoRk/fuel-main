@extends('layouts.app')

@section('content')
<div class="container">
    <h2>⛽ قائمة عمليات التعبئة</h2>
    <a href="{{ route('refuelings.create') }}" class="btn btn-primary mb-3">إضافة عملية تعبئة جديدة</a>

    
        <!-- نموذج الفلترة -->
    <form method="GET" action="{{ route('refuelings.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="car_id">السيارة:</label>
                <select name="car_id" id="car_id" class="form-control">
                    <option value="">جميع السيارات</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                            {{ $car->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="tank_id">الخزان:</label>
                <select name="tank_id" id="tank_id" class="form-control">
                    <option value="">جميع الخزانات</option>
                    @foreach($tanks as $tank)
                        <option value="{{ $tank->id }}" {{ request('tank_id') == $tank->id ? 'selected' : '' }}>
                            {{ $tank->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="date">التاريخ:</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3 align-self-end">
                <button type="submit" class="btn btn-primary">بحث</button>
                <a href="{{ route('refuelings.index') }}" class="btn btn-secondary">إعادة تعيين</a>
            </div>
        </div>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>السيارة</th>
                <th>الخزان</th>
                <th>الكمية المعبأة</th>
                <th>التاريخ</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($refuelings as $refueling)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $refueling->car->name }}</td>
                <td>{{ $refueling->tank->name }}</td>
                <td>{{ $refueling->filled_quantity }}</td>
                <td>{{ $refueling->date }}</td>
                <td>
                    <a href="{{ route('refuelings.show', $refueling->id) }}" class="btn btn-info btn-sm">عرض</a>
                    <a href="{{ route('refuelings.edit', $refueling->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                    <form action="{{ route('refuelings.destroy', $refueling->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
