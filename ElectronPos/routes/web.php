<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CattegoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CartController;


/*
Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::resource('products', ProductController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('orders', OrderController::class);

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);
*/

Route::get('/', [DashboardController::class, 'welcome']);
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/create-product', [ProductController::class, 'create'])->name('create-product');
	Route::get('/search/products', [ProductController::class, 'searchProducts'])->name('/search/products');
	Route::post('/add-to-cart/{product}', [ProductController::class, 'addToCart'])->name('product.addToCart');
	Route::get('/create-stock', [StockController::class, 'create'])->name('create-stock');
	Route::post('/submit-product', [ProductController::class, 'store'])->name('submit-product');
	Route::get('/updateProduct/{id}', [ProductController::class, 'editProduct'])->name('updateProduct');
	Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');
	Route::get('/cart', [CartController::class, 'index'])->name('cart-index');
	Route::get('/create-cattegory', [CattegoryController::class, 'create'])->name('create-cattegory');
	Route::post('/add-to-cart/{product}',[ProductController::class, 'autoAddToCart'])->name('product.autoAddToCart');
	Route::post('/submit-cattegory', [CattegoryController::class, 'store'])->name('submit-cattegory');
	Route::post('/submit-employee', [EmployeeController::class, 'store'])->name('submit-employee');
	Route::get('/sell-product', [SalesController::class, 'create'])->name('sell-product');
	Route::post('add-to-cart',[CartController::class],'addToCart')->name('add-to-cart');
	Route::get('/create-suppliers', [SuppliersController::class, 'create'])->name('create-suppliers');
	Route::post('/submit-suppliers', [SupplierController::class, 'store'])->name('submit-suppliers');
	Route::get('/create-sales', [SalesController::class, 'index'])->name('create-sales');
	Route::post('/submit-sale', [SalesController::class, 'store'])->name('submit-sale');
	Route::get('/create-employee', [EmployeeController::class, 'create'])->name('create-employee');
	Route::get('/view-products', [ProductController::class, 'viewProducts'])->name('view-products');
	Route::get('/view-employees', [EmployeeController::class, 'viewEmployees'])->name('view-employees');
	Route::get('/view-cattegories', [CattegoryController::class, 'viewCattegories'])->name('view-cattegories');
	Route::get('/view-suppliers', [SupplierController::class, 'viewSuppliers'])->name('view-suppliers');
	Route::get('/create-customers', [CustomerController::class, 'create'])->name('create-customers');
	Route::get('/view-stock', [StockController::class, 'viewStock'])->name('view-stock');
	Route::get('/stock/add/{product}', [StockController::class, 'addToStock'])->name('stock.add');
	Route::get('/stock/edit/{product}', [StockController::class, 'editStock'])->name('stock.edit');
	Route::post('/submit-stock', [StockController::class, 'submitProductToStock'])->name('submit.stock');
	Route::post('/submit-customers', [CustomerController::class, 'store'])->name('submit-customers');
	Route::get('/sell-product', [PosController::class, 'create'])->name('sell-product');
	Route::get('/create-suppliers', [SupplierController::class, 'create'])->name('create-suppliers');
	Route::post('/submit-supplier', [SupplierController::class, 'store'])->name('submit-supplier');
	Route::post('/submit-customer', [CustomerController::class, 'store'])->name('submit-customer');
	Route::get('/view-customers', [CustomerController::class, 'viewAllCustomers'])->name('view-customers');
	Route::get('/view-orders', [OrdersController::class, 'index'])->name('view-orders');
	Route::get('/view-reports', [ReportController::class, 'create'])->name('view-reports');
	Route::get('/edit-product/{id}', [ProductController::class, 'editProduct'])->name('edit-product');
	Route::post('/search-cart-product',[CartController::class, 'searchCartProduct'])->name('search-cart-product');
	//Route::get('/get-product/{id}',[PosController::class, 'create']);
	Route::get('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete-customer');
	//sales controller (route to get the controller for sales)
	Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);
	Route::get('/cart', [CartController::class, 'index'])->name('cart-index');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('user-management', function () {
		return view('pages.laravel-examples.user-management');
	})->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
});