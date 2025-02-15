@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🚗 إضافة سيارة جديدة</h2>

    <form action="{{ route('cars.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>اسم السيارة</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>نوع الوقود</label>
            <input type="text" name="fuel_type" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>المخصص الشهري</label>
            <input type="number" name="monthly_allowance" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>رقم السيارة</label>
            <input type="text" name="plate_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>القسم</label>
            <select name="section_id" class="form-control">
                @foreach($sections as $section)
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">إضافة</button>
    </form>
</div>
@endsection
