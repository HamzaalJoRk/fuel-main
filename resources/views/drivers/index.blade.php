@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🚖 قائمة السائقين</h2>
    <a href="{{ route('drivers.create') }}" class="btn btn-primary mb-3">إضافة سائق جديد</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>رقم الهاتف</th>
                <th>القسم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drivers as $driver)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $driver->name }}</td>
                <td>{{ $driver->phone }}</td>
                <td>{{ $driver->section->name }}</td>
                <td>
                    <a href="{{ route('drivers.show', $driver->id) }}" class="btn btn-info btn-sm">عرض</a>
                    <a href="{{ route('drivers.edit', $driver->id) }}" class="btn btn-warning btn-sm">تعديل</a>
                    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display:inline;">
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
