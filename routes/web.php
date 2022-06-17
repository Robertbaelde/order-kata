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


Route::get('place-order', function (\League\Tactician\CommandBus $commandBus){
    $orderId = \Kata\Order\OrderId::new();
    $commandBus->handle(new \Kata\Order\Commands\PlaceOrder($orderId));

    return 'Order placed, id: ' . $orderId->toString();
});

Route::get('select-payment-method/{orderId}/{method}', function (string $orderId, string $method, \League\Tactician\CommandBus $commandBus){
    $method = \Kata\Payments\PaymentMethod::tryFrom($method);
    $orderId = new \Kata\Order\OrderId($orderId);
    $commandBus->handle(new \Kata\Payments\Commands\SelectPaymentMethod(\Kata\Payments\PaymentReference::fromOrderId($orderId), $method));
    return "payment method {$method->name} selected";
});

Route::get('authorize-payment/{orderId}', function (string $orderId, \League\Tactician\CommandBus $commandBus){
    $orderId = new \Kata\Order\OrderId($orderId);
    $commandBus->handle(new \Kata\Payments\Commands\AuthorizePayment(\Kata\Payments\PaymentReference::fromOrderId($orderId)));
    return 'payment method authorized';
});

Route::get('increase-stock', function (\League\Tactician\CommandBus $commandBus){
   $commandBus->handle(new \Kata\Warehouse\Commands\IncreaseStock(1));
   return 'stock increased';
});

Route::get('place-purchase-order/{company}', function (string $company, \League\Tactician\CommandBus $commandBus){
    $orderId = \Kata\Order\OrderId::new();
    $commandBus->handle(new \Kata\PurchaseOrder\Commands\PlacePurchaseOrder($orderId, $company));
    return 'purchase order placed';
});

Route::get('trust-company/{company}', function (string $company, \League\Tactician\CommandBus $commandBus){
    $commandBus->handle(new \Kata\PurchaseOrder\Commands\TrustCompany($company));
    return 'company trusted';
});




Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
