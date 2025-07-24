@extends('layouts.app')

@section('content')
    <h2>⛽ إضافة عملية تعبئة جديدة</h2>

    @if(session('error'))
        <div class="alert alert-danger">
            <strong>تنبيه!</strong> {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            <strong>نجاح!</strong> {{ session('success') }}
        </div>
    @endif

    @if(session('car_remaining_allowance'))
        <div class="mb-2">
            <label>المستحقات المتبقية للسيارة</label>
            <input type="text" class="form-control" value="{{ session('car_remaining_allowance') }}" disabled>
        </div>
    @endif

    <form action="{{ route('refuelings.store') }}" method="POST">
        @csrf

        <!-- بحث داخل القائمة -->
        <div class="mb-2 position-relative">
            <label>اختر سيارة</label>
            <input type="text" id="carSearchInput" class="form-control" placeholder="ابحث عن السيارة بالاسم أو رقم اللوحة" autocomplete="off">
            <input type="hidden" name="car_id" id="selectedCarId">
            <ul id="carList" class="list-group position-absolute w-100" style="z-index:1000; max-height: 200px; overflow-y: auto; display: none;">
                @foreach ($cars as $car)
                    <li class="list-group-item list-group-item-action"
                        data-id="{{ $car->id }}">
                        {{ $car->name }} - {{ $car->plate_number }} - {{ $car->section->name ?? 'بدون قسم' }}
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- الخزان -->
        <div class="mb-2">
            <label>الخزان</label>
            <select name="tank_id" class="form-control" required id="tank_id">
                <option value="">اختر خزان</option>
                @foreach ($tanks as $tank)
                    <option value="{{ $tank->id }}" data-remaining="{{ $tank->remaining_quantity }}">
                        {{ $tank->name }}
                    </option>
                @endforeach
            </select>
        </div>

        @if(session('tank_remaining_quantity'))
            <div class="mb-2">
                <label>الكمية المتبقية في الخزان</label>
                <input type="text" id="remaining_quantity" class="form-control" value="{{ session('tank_remaining_quantity') }}" disabled>
            </div>
        @endif

        <div class="mb-2">
            <label>الكمية المعبأة</label>
            <input type="number" name="filled_quantity" class="form-control" required>
        </div>

        <div class="mb-2">
            <label>التاريخ</label>
            <input type="date" name="date" class="form-control" required value="{{ date('Y-m-d') }}">
        </div>

        <button type="submit" class="btn btn-success">إضافة</button>
    </form>

    <!-- JS للبحث داخل القائمة -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('carSearchInput');
            const list = document.getElementById('carList');
            const items = list.querySelectorAll('li');
            const hiddenInput = document.getElementById('selectedCarId');

            input.addEventListener('input', function () {
                const search = this.value.toLowerCase();
                let anyMatch = false;

                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    const match = text.includes(search);
                    item.style.display = match ? 'block' : 'none';
                    if (match) anyMatch = true;
                });

                list.style.display = anyMatch ? 'block' : 'none';
            });

            items.forEach(item => {
                item.addEventListener('click', function () {
                    input.value = this.textContent;
                    hiddenInput.value = this.getAttribute('data-id');
                    list.style.display = 'none';
                });
            });

            // إخفاء القائمة إذا خرج المؤشر منها
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.position-relative')) {
                    list.style.display = 'none';
                }
            });
        });
    </script>
@endsection
