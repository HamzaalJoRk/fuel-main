@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🛢️ إضافة خزان جديد</h2>

    <form action="{{ route('tanks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>اسم الخزان</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>نوع الوقود</label>
            <input type="text" name="fuel_type" class="form-control" required>
        </div>
        <!-- <div class="mb-3">
            <label>المتبقي</label>
            <input type="number" name="remaining" class="form-control" required>
        </div> -->
        <div class="mb-3">
            <label>السعة الكلية</label>
            <input type="number" name="total_capacity" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">إضافة</button>
    </form>
</div>
@endsection
