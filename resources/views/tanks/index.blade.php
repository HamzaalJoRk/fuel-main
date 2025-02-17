@extends('layouts.app')

@section('content')
    <h2>🛢️ قائمة الخزانات</h2>
    <a href="{{ route('tanks.create') }}" class="btn btn-primary mb-3">إضافة خزان جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>اسم الخزان</th>
                <th>نوع الوقود</th>
                <th>المتبقي</th>
                <th>السعة الكلية</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tanks as $tank)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tank->name }}</td>
                <td>{{ $tank->fuel_type }}</td>
                <td>{{ $tank->remaining_quantity }}</td>
                <td>{{ $tank->total_capacity }}</td>
                <td>
                    <a href="{{ route('tanks.show', $tank->id) }}" class="btn btn-info btn-sm">عرض</a>
                    <a href="{{ route('tanks.edit', $tank->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                    <form action="{{ route('tanks.destroy', $tank->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
