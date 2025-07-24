<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TankController;
use App\Http\Controllers\RefuelingController;
use App\Http\Controllers\CarBrandController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    // return view('dashboard');
    return redirect('/refuelings');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/users', function () {
    return view('users.index');
})->middleware('auth')->name('users.index');
Route::get('/users/edit/{id}', 'UserController@edit')->name('users.edit');


Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::get('user-create',[ UserController::class,'create_user']);
Route::resource('products', ProductController::class);
//Route::resource('permissions', PermissionController::class);

Route::middleware(['auth']) // Implement admin middleware to restrict access
->group(function () {
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permissions-create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{permission}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::get('refuelings', [RefuelingController::class, 'index'])->name('refuelings.index');
    Route::get('refuelings-create', [RefuelingController::class, 'create'])->name('refuelings.create');
    Route::post('refuelings', [RefuelingController::class, 'store'])->name('refuelings.store');
    Route::get('refuelings/{refueling}', [RefuelingController::class, 'show'])->name('refuelings.show');
    Route::get('refuelings/{refueling}/edit', [RefuelingController::class, 'edit'])->name('refuelings.edit');
    Route::put('refuelings/{refueling}', [RefuelingController::class, 'update'])->name('refuelings.update');
    Route::delete('refuelings/{refueling}', [RefuelingController::class, 'destroy'])->name('refuelings.destroy');

    Route::get('cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('cars-create', [CarController::class, 'create'])->name('cars.create');
    Route::post('cars', [CarController::class, 'store'])->name('cars.store');
    Route::get('cars/{car}', [CarController::class, 'show'])->name('cars.show');
    Route::get('cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
    Route::put('cars/{car}', [CarController::class, 'update'])->name('cars.update');
    Route::delete('cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');

    Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('drivers-create', [DriverController::class, 'create'])->name('drivers.create');
    Route::post('drivers', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('drivers/{driver}', [DriverController::class, 'show'])->name('drivers.show');
    Route::get('drivers/{driver}/edit', [DriverController::class, 'edit'])->name('drivers.edit');
    Route::put('drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
    Route::delete('drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');

    Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
    Route::get('sections-create', [SectionController::class, 'create'])->name('sections.create');
    Route::post('sections', [SectionController::class, 'store'])->name('sections.store');
    Route::get('sections/{section}', [SectionController::class, 'show'])->name('sections.show');
    Route::get('sections/{section}/edit', [SectionController::class, 'edit'])->name('sections.edit');
    Route::put('sections/{section}', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy');

    Route::get('tanks', [TankController::class, 'index'])->name('tanks.index');
    Route::get('tanks-create', [TankController::class, 'create'])->name('tanks.create');
    Route::post('tanks', [TankController::class, 'store'])->name('tanks.store');
    Route::get('tanks/{tank}', [TankController::class, 'show'])->name('tanks.show');
    Route::get('tanks/{tank}/edit', [TankController::class, 'edit'])->name('tanks.edit');
    Route::put('tanks/{tank}', [TankController::class, 'update'])->name('tanks.update');
    Route::delete('tanks/{tank}', [TankController::class, 'destroy'])->name('tanks.destroy');

    Route::get('/tanks/{tank}/calculate', [TankController::class, 'showCalculateForm'])->name('tanks.calculate');
    Route::post('/tanks/{tank}/calculate', [TankController::class, 'calculateRemaining']);


    Route::get('car_brands', [CarBrandController::class, 'index'])->name('car_brands.index'); // عرض جميع العلامات
    Route::get('car_brands-create', [CarBrandController::class, 'create'])->name('car_brands.create'); // صفحة الإضافة
    Route::post('car_brands', [CarBrandController::class, 'store'])->name('car_brands.store'); // حفظ العلامة الجديدة
    Route::get('car_brands/{carBrand}/edit', [CarBrandController::class, 'edit'])->name('car_brands.edit'); // صفحة التعديل
    Route::put('car_brands/{carBrand}', [CarBrandController::class, 'update'])->name('car_brands.update'); // تحديث البيانات
    Route::delete('car_brands/{carBrand}', [CarBrandController::class, 'destroy'])->name('car_brands.destroy'); // حذف العلامة


    // Route::resource('refuelings', RefuelingController::class);
    // Route::resource('cars', CarController::class);
    // Route::resource('drivers', DriverController::class);
    // Route::resource('sections', SectionController::class);
    // Route::resource('tanks', TankController::class);
});
//Route::get('/users', [UserController::class, 'index'])->name('users.index');
require __DIR__.'/auth.php';
