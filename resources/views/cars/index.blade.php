@extends('layouts.app')

@section('content')
    <h2>🚗 قائمة السيارات</h2>
    <a href="{{ route('cars.create') }}" class="btn btn-primary mb-3">إضافة سيارة جديدة</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>نوع الوقود</th>
                <th>المخصص الشهري</th>
                <th>المستحقات المتبقية</th>
                <th>رقم السيارة</th>
                <th>القسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cars as $car)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $car->name }}</td>
                <td>{{ $car->fuel_type }}</td>
                <td>{{ number_format($car->monthly_allowance, 2) }}</td>
                <td>{{ number_format($car->remaining_allowance, 2) }}</td> 
                <td>{{ $car->plate_number }}</td>
                <td>{{ $car->section->name }}</td>
                <td>
                    <a href="{{ route('cars.show', $car->id) }}" class="btn btn-info btn-sm">عرض</a>
                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
