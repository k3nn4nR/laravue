<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/human_resources', function(){return view('human_resources');})->name('human_resources');
    Route::get('/logistics', function(){return view('logistics');})->name('logistics');
    Route::get('/works', function(){return view('works');})->name('works');
    Route::get('/dashboard_people', function(){return view('dashboard.people');})->name('dashboard_people');

    Route::name('people.')->group(function () {
        Route::get('/people', [App\Http\Controllers\PersonController::class, 'index'])->name('index');
        Route::post('/people', [App\Http\Controllers\PersonController::class, 'store'])->name('store');
        Route::put('/people/{person}', [App\Http\Controllers\PersonController::class, 'update'])->name('update');
        Route::get('/people/{id_number}', [App\Http\Controllers\PersonController::class, 'show'])->name('show');
        Route::get('/people/{id_number}/edit', [App\Http\Controllers\PersonController::class, 'edit'])->name('edit');
    });

    Route::name('item.')->group(function () {
        Route::get('/item', [App\Http\Controllers\ItemController::class, 'index'])->name('index');
        Route::post('/item', [App\Http\Controllers\ItemController::class, 'store'])->name('store');
        Route::put('/item', [App\Http\Controllers\ItemController::class, 'update'])->name('update');
        Route::get('/item/{code}', [App\Http\Controllers\ItemController::class, 'show'])->name('show');
        Route::get('/item/{code}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('edit');
        Route::get('/item-registration', [App\Http\Controllers\ItemController::class, 'create'])->name('create');
    });

    Route::name('design.')->group(function () {
        Route::get('/design', [App\Http\Controllers\ItemController::class, 'designIndex'])->name('index');
        Route::post('/design', [App\Http\Controllers\ItemController::class, 'designStore'])->name('store');
        Route::put('/design', [App\Http\Controllers\ItemController::class, 'designUpdate'])->name('update');
        Route::get('/design/{design}', [App\Http\Controllers\ItemController::class, 'designShow'])->name('show');
    });

    Route::name('company.')->group(function () {
        Route::get('/company', [App\Http\Controllers\CompanyController::class, 'getCompanies'])->name('index');
        Route::post('/company', [App\Http\Controllers\CompanyController::class, 'storeCompanies'])->name('store');
        Route::get('/company/{id_number}', [App\Http\Controllers\CompanyController::class, 'show'])->name('show');
        Route::put('/company/{company}', [App\Http\Controllers\CompanyController::class, 'update'])->name('update');
    });

    Route::name('client.')->group(function () {
        Route::get('/client', [App\Http\Controllers\CompanyController::class, 'getClients'])->name('index');
        Route::get('/client-registration',[App\Http\Controllers\COmpanyController::class, 'createClients'])->name('create');
        Route::post('/client', [App\Http\Controllers\CompanyController::class, 'storeClients'])->name('store');
    });

    Route::name('provider.')->group(function () {
        Route::get('/provider', [App\Http\Controllers\CompanyController::class, 'getProviders'])->name('index');
        Route::get('/provider-registration',[App\Http\Controllers\COmpanyController::class, 'createProviders'])->name('create');
        Route::post('/provider', [App\Http\Controllers\CompanyController::class, 'storeProviders'])->name('store');
    });

    Route::name('position.')->group(function () {
        Route::get('/position', [App\Http\Controllers\PositionController::class, 'index'])->name('index');
        Route::post('/position', [App\Http\Controllers\PositionController::class, 'store'])->name('store');
        Route::put('/position/{position}', [App\Http\Controllers\PositionController::class, 'update'])->name('update');
        Route::get('/position/{id}', [App\Http\Controllers\PositionController::class, 'show'])->name('show');
        Route::get('/getOrganigramp', [App\Http\Controllers\PositionController::class, 'getOrganigram'])->name('getOrganigram');
        Route::delete('/position-pivot/{id}', [App\Http\Controllers\PositionController::class, 'destroyPivot'])->name('destroyPivot');
    });

    Route::name('area.')->group(function () {
        Route::get('/area', [App\Http\Controllers\AreaController::class, 'index'])->name('index');
        Route::post('/area', [App\Http\Controllers\AreaController::class, 'store'])->name('store');
        Route::put('/area/{area}', [App\Http\Controllers\AreaController::class, 'update'])->name('update');
        Route::get('/area/{id}', [App\Http\Controllers\AreaController::class, 'show'])->name('show');
        Route::get('/getOrganigram', [App\Http\Controllers\AreaController::class, 'getOrganigram'])->name('getOrganigram');
        Route::delete('/area-pivot/{id}', [App\Http\Controllers\AreaController::class, 'destroyPivot'])->name('destroyPivot');
    });

    Route::name('document_type.')->group(function () {
        Route::get('/document_type', [App\Http\Controllers\DocumentTypeController::class, 'index'])->name('index');
        Route::post('/document_type', [App\Http\Controllers\DocumentTypeController::class, 'store'])->name('store');
        Route::get('/document_type/{id}', [App\Http\Controllers\DocumentTypeController::class, 'show'])->name('show');
    });

    Route::name('contract.')->group(function () {
        Route::get('/contract', [App\Http\Controllers\ContractController::class, 'index'])->name('index');
        Route::get('/new_contract', [App\Http\Controllers\ContractController::class, 'create'])->name('create');
        Route::post('/contract', [App\Http\Controllers\ContractController::class, 'store'])->name('store');
        Route::get('/people/{id_number}/contract/{id}', [App\Http\Controllers\ContractController::class, 'show'])->name('show');
    });

    Route::name('dashboard.')->group(function () {
        Route::get('/people-dashboard', [App\Http\Controllers\DashboardController::class, 'people'])->name('people');
        Route::get('/works-dashboard', [App\Http\Controllers\DashboardController::class, 'works'])->name('works');
    });

    Route::name('document_type.')->group(function () {
        Route::get('/document_type', [App\Http\Controllers\DocumentTypeController::class, 'index'])->name('index');
    });

    Route::name('export.')->group(function () {
        Route::get('/export-people-pdf', [App\Http\Controllers\ExportsController::class, 'pdfExport'])->name('pdfExport');
        Route::get('/export-people-excel', [App\Http\Controllers\ExportsController::class, 'excelExport'])->name('excelExport');
    });

    Route::name('work.')->group(function () {
        Route::get('/work', [App\Http\Controllers\WorkController::class, 'index'])->name('index');
        Route::get('/work-registration', [App\Http\Controllers\WorkController::class, 'create'])->name('create');
        Route::post('/work', [App\Http\Controllers\WorkController::class, 'store'])->name('store');
        Route::post('/work-people', [App\Http\Controllers\WorkController::class, 'storePeople'])->name('storePeople');
        Route::put('/work/{work}', [App\Http\Controllers\WorkController::class, 'update'])->name('update');
        Route::get('/work/{work}', [App\Http\Controllers\WorkController::class, 'show'])->name('show');
    });

    Route::name('brand.')->group(function () {
        Route::get('/brand', [App\Http\Controllers\BrandController::class, 'index'])->name('index');
        Route::post('/brand', [App\Http\Controllers\BrandController::class, 'store'])->name('store');
    });

    Route::name('design.')->group(function () {
        Route::get('/design', [App\Http\Controllers\DesignController::class, 'index'])->name('index');
        Route::post('/design', [App\Http\Controllers\DesignController::class, 'store'])->name('store');
    });
});
