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
use App\Http\Controllers\ElectronPOE;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShopController;



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
	Route::get('/view-orders', [OrdersController::class, 'index'])->name('orders-index');
	Route::get('/search-product/{productName}', [ProductController::class, 'searchProduct']);
	Route::post('/sell', [SaleController::class, 'store'])->name("submit.sale");
	Route::get('/cart', [ElectronPOE::class, 'index'])->name('cart-index');
	Route::get('/create-grn', [StockController::class, 'createGRN'])->name('create-grn');
	Route::get('/create-grn-view', [StockController::class, 'createGRNView'])->name('create-grn-view');
	Route::get('/create-product', [ProductController::class, 'create'])->name('create-product');
	//Route::get('/products-json/{productName}', [ProductController::class, 'searchProducts']);
	Route::post('/add-to-cart/{product}', [CartController::class, 'addToCart'])->name('add-to-cart');
	//Route::post('/addcart/{id}',[CartController::class],'addToCart')->name('add-to-cart');
	Route::get('/search/products', [ProductController::class, 'searchProducts'])->name('/search/products');
	Route::get('/view-sales', [SalesController::class, 'index'])->name('sales.index');
	Route::get('/create-stock', [StockController::class, 'create'])->name('create-stock');
	Route::post('/submit-product', [ProductController::class, 'store'])->name('submit-product');
	Route::post('/submit-grv', [StockController::class, 'store'])->name('submit-grv');
	Route::get('/updateProduct/{id}', [ProductController::class, 'editProduct'])->name('updateProduct');
	Route::get('/edit-supplier/{id}', [SupplierController::class, 'editSupplier'])->name('edit-supplier');
	Route::get('/edit-customer/{id}', [CustomerController::class, 'editCustomer'])->name('edit-customer');
	Route::get('/edit-/group{id}', [CattegoryController::class, 'editGroup'])->name('edit-group');
	Route::put('/update/customer/{customer}', [CustomerController::class, 'updateCustomer'])->name('update-customer');
	Route::put('/update/cattegory/{cattegory}', [CattegoryController::class, 'updateCattegory'])->name('update-cattegory');
	Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');
	Route::get('/create-cattegory', [CattegoryController::class, 'create'])->name('create-cattegory');
	Route::put('/update-product/{product}',[ProductController::class, 'updateProduct'])->name('products.update');
	Route::put('/supplier-update/{supplier}',[SupplierController::class, 'updateSupplier'])->name('supplier.update');
	Route::put('/customer-update/{customer}',[SupplierController::class, 'updateCustomer'])->name('customer.update');
	Route::post('/submit-cattegory', [CattegoryController::class, 'store'])->name('submit-cattegory');
	Route::post('/submit-employee', [ShopController::class, 'store'])->name('submit-shop');
	Route::post('/submit-shop', [ShopController::class, 'store'])->name('submit-shop');
	Route::get('/sell-product', [SalesController::class, 'create'])->name('sell-product');
	Route::get('/products-json/{productName}', [ProductController::class, 'searchByName'])->name('products.searchByName');
	//loop through the products and then add them to cart
	Route::get('/create-suppliers', [SuppliersController::class, 'create'])->name('create-suppliers');
	Route::post('/submit-suppliers', [SupplierController::class, 'store'])->name('submit-suppliers');
	Route::get('/create-sales', [SalesController::class, 'index'])->name('create-sales');
	Route::post('/submit-sale', [SalesController::class, 'store'])->name('submit-sale');
	Route::get('/create-employee', [EmployeeController::class, 'create'])->name('create-employee');
	Route::get('/view-products', [ProductController::class, 'viewProducts'])->name('view-products');
	Route::get('/view-products', [ProductController::class, 'viewProducts'])->name('view-products');
	Route::get('/view-employees', [EmployeeController::class, 'viewEmployees'])->name('view-employees');
	Route::get('/view-cattegories', [CattegoryController::class, 'viewCattegories'])->name('view-cattegories');
	Route::get('/view-suppliers', [SupplierController::class, 'viewSuppliers'])->name('view-suppliers');
	Route::get('/view-shop', [ShopController::class, 'index'])->name('view-shop');
	Route::get('/create-customers', [CustomerController::class, 'create'])->name('create-customers');
	Route::get('/view-stock', [StockController::class, 'viewStock'])->name('view-stock');
	Route::get('/view-all-stock-items', [StockController::class, 'viewAllStockItems'])->name('viewall-stock');
	Route::get('/stock/add/{product}', [StockController::class, 'addToStock'])->name('stock.add');
	Route::get('/stock/edit/{product}', [StockController::class, 'editStock'])->name('stock.edit');
	Route::post('/submit-stock', [StockController::class, 'submitProductToStock'])->name('submit.stock');
	Route::post('/submit-customers', [CustomerController::class, 'store'])->name('submit-customers');
	Route::get('/sell-product', [SalesController::class, 'index'])->name('sell-product');
	Route::get('/create-suppliers', [SupplierController::class, 'create'])->name('create-suppliers');
	Route::post('/submit-supplier', [SupplierController::class, 'store'])->name('submit-supplier');
	Route::post('/submit-customer', [CustomerController::class, 'store'])->name('submit-customer');
	Route::get('/view-customers', [CustomerController::class, 'viewAllCustomers'])->name('view-customers');
	Route::get('/view-orders', [OrdersController::class, 'index'])->name('view-orders');
	Route::get('/view-reports', [ReportController::class, 'create'])->name('view-reports');
	Route::get('/edit-product/{id}', [ProductController::class, 'editProduct'])->name('edit-product');
	Route::get('/delete-group/{id}', [CattegoryController::class, 'deleteCattegory'])->name('delete-group');
	Route::get('/delete-supplier/{id}', [SupplierController::class, 'deleteSupplier'])->name('delete-supplier');
	Route::get('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete-customer');
	Route::post('/search-cart-product',[CartController::class, 'searchCartProduct'])->name('search-cart-product');
	//Route::get('/get-product/{id}',[PosController::class, 'create']);
	Route::get('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete-customer');
	//Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
	//sales controller (route to get the controller for sales)
	Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);
	//api routes
	Route::get('/products-json', [ProductController::class, 'getProductsJson'])->name('products-json');
	Route::get('/products-sell', [ProductController::class, 'getAllProductsJson'])->name('all-products-json');
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