<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CreateUserController;
use App\Http\Controllers\CreateCustomerController;
use App\Http\Controllers\CreateServiceController;
use App\Http\Controllers\CreatePaymentController;
use App\Http\Controllers\CreateOrderController;
use App\Http\Controllers\WelcomeController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])
->name('welcome.index');

Route::middleware('auth')->group(function () {

    Route::middleware([CheckRole::class . ':petugas,admin'])->group(function () {
    
        Route::get('customer', [CreateCustomerController::class, 'index'])
        ->name('customer.index');
        Route::get('/customer/create-customer', [CreateCustomerController::class, 'create'])
        ->name('create.customer');
        Route::post('/customer/create-customer', [CreateCustomerController::class, 'store']);
        Route::get('customer/edit', [CreateCustomerController::class, 'edit'])->name('customer.edit');
        Route::put('/customer/{id}', [CreateCustomerController::class, 'update'])->name('customer.update');
        Route::delete('/customer/destroy', [CreateCustomerController::class, 'destroy'])->name('customer.destroy');

        Route::get('/order/create-order', [CreateOrderController::class, 'create'])
        ->name('create.order');
        Route::post('/order/create-order', [CreateOrderController::class, 'store']);
        Route::get('order/edit', [CreateOrderController::class, 'edit'])->name('order.edit');
        Route::put('/order/{id}', [CreateOrderController::class, 'update'])->name('order.update');
        Route::delete('/order/destroy', [CreateOrderController::class, 'destroy'])->name('order.destroy');

    });

    Route::middleware([CheckRole::class . ':admin'])->group(function () {

        Route::get('users', [CreateUserController::class, 'index'])
        ->name('users.index');
        Route::get('/users/create-users', [CreateUserController::class, 'create'])
        ->name('create.users');
        Route::post('/users/create-users', [CreateUserController::class, 'store']);
        Route::get('users/edit', [CreateUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [CreateUserController::class, 'update'])->name('users.update');
        Route::delete('/users/destroy', [CreateUserController::class, 'destroy'])->name('users.destroy');
    
        Route::get('service', [CreateServiceController::class, 'index'])
        ->name('service.index');
        Route::get('/service/create-service', [CreateServiceController::class, 'create'])
        ->name('create.service');
        Route::post('/service/create-service', [CreateServiceController::class, 'store']);
        Route::get('service/edit', [CreateServiceController::class, 'edit'])->name('service.edit');
        Route::put('/service/{id}', [CreateServiceController::class, 'update'])->name('service.update');
        Route::delete('/service/destroy', [CreateServiceController::class, 'destroy'])->name('service.destroy');
        
        Route::get('payment', [CreatePaymentController::class, 'index'])
        ->name('payment.index');
        Route::get('/payment/create-payment', [CreatePaymentController::class, 'create'])
        ->name('create.payment');
        Route::post('/payment/create-payment', [CreatePaymentController::class, 'store']);
        Route::get('payment/edit', [CreatePaymentController::class, 'edit'])->name('payment.edit');
        Route::put('/payment/{id}', [CreatePaymentController::class, 'update'])->name('payment.update');
        Route::delete('/payment/destroy', [CreatePaymentController::class, 'destroy'])->name('payment.destroy');
        
    });

    Route::get('order', [CreateOrderController::class, 'index'])
    ->name('order.index');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
