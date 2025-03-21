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
use App\Http\Controllers\GrvController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SetStockLevelsController;
use App\Http\Controllers\CompanyDataController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\SaleZigController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\PaymentTypesController;
use App\Http\Controllers\AddPrinterController;
use App\Http\Controllers\PriceListsController;
use App\Http\Controllers\EmployeeLogin;
use App\Http\Controllers\FiscalController;


Route::get('/', [DashboardController::class, 'welcome']);
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
Route::get('/employee/login', [EmployeeLogin::class, 'showLoginForm'])->name('employee.login')->middleware('guest');
Route::get('/cart', [ElectronPOE::class, 'index'])->name('cart-index');
Route::post('/employee/login/submit', [EmployeeLogin::class, 'store'])->name('employee.login.submit')->middleware('guest');
Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('/view-orders', [OrdersController::class, 'index'])->name('orders-index');
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
	Route::get('/search-product/{productName}', [ProductController::class, 'searchProduct']);
	Route::post('/sell', [SaleController::class, 'store'])->name("submit.sale");
	Route::post('/sellZig', [SaleZigController::class, 'store'])->name("submit.sale");
	Route::get('/zig-screen', [ElectronPOE::class, 'zigScreen'])->name('zig-screen');
	Route::get('/create-grn', [GRVController::class, 'createGRN'])->name('create-grn');
	Route::get('/grv-enquiry', [GRVController::class, 'grvEnquiry'])->name('grv-enquiry');
	Route::post('/grv-enquiry', [GRvController::class, 'queryGRV'])->name("search.grv");
	Route::get('/grn/{id}', [GRVController::class, 'viewById'])->name('grn.show');
	Route::get('/update-grv/{id}', [GRVController::class, 'updateById'])->name('update-grv');
	Route::put('/grv/{id}', [GRVController::class, 'sendUpdate'])->name('grv.send-update');
	Route::put('/edit-payment-type/{id}', [PaymentTypesController::class, 'sendUpdate'])->name('paymentTypes.send-update');
	Route::get('/view-purchaseorder/{id}', [PurchaseOrderController::class, 'viewById'])->name('purchaseorder.show');
	Route::get('/purchase-order/{id}', [PurchaseOrderController::class, 'showSinglePurchaseOrder'])->name('purchase-order.show');
	Route::get('/quote/{id}', [QuoteController::class, 'showSingleQuote'])->name('quote.show');
	Route::get('/create-grn-view', [StockController::class, 'createGRNView'])->name('create-grn-view');
	Route::get('/create-product', [ProductController::class, 'create'])->name('create-product');
	Route::post('/add-to-cart/{product}', [CartController::class, 'addToCart'])->name('add-to-cart');
	//search products
	Route::get('/search/products', [ProductController::class, 'searchProducts'])->name('/search/products');
	Route::get('/view-sales', [SalesController::class, 'index'])->name('sales.index');
	Route::get('/create-stock', [StockController::class, 'create'])->name('create-stock');
	Route::get('/stock-enquiry', [StockController::class, 'enquire'])->name('stock-enquiry');
	Route::post('/submit-product', [ProductController::class, 'store'])->name('submit-product');
	Route::post('/enquire-stock', [StockController::class, 'searchStock'])->name('enquire-stock');
	Route::post('/submit-grv', [StockController::class, 'store'])->name('submit-grv');
	Route::get('/updateProduct/{id}', [ProductController::class, 'editProduct'])->name('updateProduct');
	Route::get('/edit-supplier/{id}', [SupplierController::class, 'editSupplier'])->name('edit-supplier');
	Route::get('/edit-customer/{id}', [CustomerController::class, 'editCustomer'])->name('edit-customer');
	Route::get('/edit-/group{id}', [CattegoryController::class, 'editGroup'])->name('edit-group');
	Route::put('/update/customer/{customer}', [CustomerController::class, 'updateCustomer'])->name('update-customer');
	Route::put('/update/cattegory/{cattegory}', [CattegoryController::class, 'updateCattegory'])->name('update-cattegory');
	Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('delete-product');
	Route::get('/delete-payment-type/{id}', [PaymentTypesController::class, 'deletePaymentType'])->name('delete-payment-type');
	Route::get('/delete-shop/{id}', [ShopController::class, 'deleteShop'])->name('delete-shop');
	Route::get('/edit-shop/{id}', [ShopController::class, 'editShop'])->name('edit-shop');
	Route::put('/update/shop/shop}', [ShopController::class, 'updateShop'])->name('update-shop');
	Route::get('/delete-employee/{id}', [EmployeeController::class, 'deleteEmployee'])->name('delete-employee');
	Route::get('/create-cattegory', [CattegoryController::class, 'create'])->name('create-cattegory');
	Route::put('/update-product/{product}',[ProductController::class, 'updateProduct'])->name('products.update');
	Route::put('/supplier-update/{supplier}',[SupplierController::class, 'updateSupplier'])->name('supplier.update');
	Route::put('/customer-update/{customer}',[SupplierController::class, 'updateCustomer'])->name('customer.update');
	Route::post('/submit-cattegory', [CattegoryController::class, 'store'])->name('submit-cattegory');
	Route::post('/submit-employee', [ShopController::class, 'store'])->name('submit-shop');
	Route::post('/submit-employee', [EmployeeController::class, 'store'])->name('submit-employee');
	Route::post('/submit-purchaseorder', [PurchaseOrderController::class, 'store'])->name('submit-purchaseorder');
	Route::post('/submit-shop', [ShopController::class, 'store'])->name('submit-shop');
	Route::get('/sell-product', [SalesController::class, 'create'])->name('sell-product');
	Route::get('/view-companydata', [CompanyDataController::class, 'index'])->name('view-companydata');
	Route::get('/select-customer-view', [SaleController::class, 'viewCustomerView'])->name('select-customer-view');
	Route::get('/access-rights', [EmployeeController::class, 'accessRights'])->name('access-rights');
	Route::get('/products/searchByName/{productName}', [ProductController::class, 'searchByName'])->name('products.searchByName');
	Route::get('/products/searchByCode/{productCode}', [ProductController::class, 'searchByCode'])->name('products.searchByCode');
	//loop through the products and then add them to cart
	Route::get('/create-suppliers', [SuppliersController::class, 'create'])->name('create-suppliers');
	Route::get('/create-purchaseorder', [PurchaseOrderController::class, 'index'])->name('create-purchaseorder');
	Route::get('/view-purchaseorder', [PurchaseOrderController::class, 'viewPurchasesOrders'])->name('view-purchaseorders');
	Route::post('/submit-suppliers', [SupplierController::class, 'store'])->name('submit-suppliers');
	Route::post('/do-transaction', [SaleController::class, 'doTransaction'])->name('do-transaction');
	Route::post('/sell-zig', [SaleZigController::class, 'doTransaction'])->name('do-transaction');
	Route::get('/create-sales', [SalesController::class, 'index'])->name('create-sales');
	Route::post('/submit-sale', [SalesController::class, 'store'])->name('submit-sale');
	Route::post('/submit-quote', [QuoteController::class, 'store'])->name('submit-quote');
	Route::get('/create-employee', [EmployeeController::class, 'create'])->name('create-employee');
	Route::get('/search-customers', [CustomerController::class, 'searchCustomers'])->name('search-customers');
	Route::get('/view-products', [ProductController::class, 'viewProducts'])->name('view-products');
	Route::get('/quote-customers', [CustomerController::class, 'quoteCustomers'])->name('quote-customers');
	Route::get('/view-products', [ProductController::class, 'viewProducts'])->name('view-products');
	Route::get('/view-employees', [EmployeeController::class, 'viewEmployees'])->name('view-employees');
	Route::get('grn/download/{id}', [GrVController::class, 'downloadPdf'])->name('grn.download');
	Route::get('/view-cattegories', [CattegoryController::class, 'viewCattegories'])->name('view-cattegories');
	Route::get('/view-suppliers', [SupplierController::class, 'viewSuppliers'])->name('view-suppliers');
	Route::get('/finish-transaction/{customerId}', [SaleController::class, 'finishTransaction'])->name('finish-transaction');
	Route::get('/view-shop', [ShopController::class, 'index'])->name('view-shop');
	Route::get('/create-customers', [CustomerController::class, 'create'])->name('create-customers');
	Route::get('/view-stock', [StockController::class, 'viewStock'])->name('view-stock');
	Route::get('/shop-list', [ShopController::class, 'viewShopList'])->name('shop-list');
	Route::get('/view-all-stock-items', [StockController::class, 'viewAllStockItems'])->name('viewall-stock');
	Route::get('/stock/add/{product}', [StockController::class, 'addToStock'])->name('stock.add');
	Route::get('/generate-grv', [GrvController::class, 'generateGrv'])->name("generate-grv");
	Route::get('/set-stock-levels', [SetStockLevelsController::class, 'index'])->name("set-stocklevels");
	Route::get('/salesInvoice', [ProductController::class, 'salesInvoice'])->name("sales-invoice");
	Route::post('/submit-stock-levels', [SetStockLevelsController::class, 'store'])->name("submit-stocklevels");
	Route::get('/stock/edit/{product}', [StockController::class, 'editStock'])->name('stock.edit');
	Route::post('/submit-stock', [StockController::class, 'submitProductToStock'])->name('submit.stock');
	Route::post('/submit-customers', [CustomerController::class, 'store'])->name('submit-customers');
	Route::get('/sell-product', [SalesController::class, 'index'])->name('sell-product');
	Route::get('/create-suppliers', [SupplierController::class, 'create'])->name('create-suppliers');
	Route::get('/list-payment-types', [PaymentTypesController::class, 'showPaymentTypes'])->name('list-payment-types');
	Route::get('/confirmation-screen', [SaleController::class, 'confirmationScreen'])->name('confirmation-screen');
	Route::post('/submit-supplier', [SupplierController::class, 'store'])->name('submit-supplier');
	Route::post('/submit-payment-type', [PaymentTypesController::class, 'store'])->name('submit-payment-type');
	Route::post('/finalise-sale', [SaleController::class, 'finaliseSale'])->name('finalise-sale');
	Route::post('/submit-customer', [CustomerController::class, 'store'])->name('submit-customer');
	Route::get('/view-customers', [CustomerController::class, 'viewAllCustomers'])->name('view-customers');
	Route::get('/view-payment-types', [PaymentTypesController::class, 'addPaymentTypes'])->name('view-payment-types');
	Route::get('/show-payment-types', [PaymentTypesController::class, 'showPaymentTypes'])->name('show-payment-types');
	Route::get('/view-orders', [OrdersController::class, 'index'])->name('view-orders');
	Route::get('/view-reports', [ReportController::class, 'create'])->name('view-reports');
	Route::get('/view-inventoryvaluation', [ReportController::class, 'viewInventoryValuationReport'])->name('view-inventoryvaluation');
	Route::get('/edit-product/{id}', [ProductController::class, 'editProduct'])->name('edit-product');
	Route::get('/edit-payment-type/{id}', [PaymentTypesController::class, 'editPaymentType'])->name('edit-payment-type');
	Route::get('/edit-employee/{id}', [EmployeeController::class, 'editEmployee'])->name('edit-employee');
	Route::get('/delete-group/{id}', [CattegoryController::class, 'deleteCattegory'])->name('delete-group');
	Route::get('/delete-supplier/{id}', [SupplierController::class, 'deleteSupplier'])->name('delete-supplier');
	Route::get('/view-pricelists', [PriceListsController::class, 'viewPriceLists'])->name('view-pricelists');
	Route::get('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete-customer');
	Route::post('/search-cart-product',[CartController::class, 'searchCartProduct'])->name('search-cart-product');
	Route::post('/submit-grv', [GrvController::class, 'submitGrv'])->name('submit-grv');
	Route::get('/delete-customer/{id}', [CustomerController::class, 'deleteCustomer'])->name('delete-customer');
	Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
	Route::get('/view-companydetails', [CompanyDataController::class, 'viewDetails'])->name('company-details');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/change-qty', [CartController::class, 'changeQty']);
    Route::delete('/cart/delete', [CartController::class, 'delete']);
    Route::delete('/cart/empty', [CartController::class, 'empty']);
	Route::post('/submit-company-details', [CompanyDataController::class, 'store'])->name('submit-company-details');
	//api routes
	Route::get('/products-json', [ProductController::class, 'getProductsJson'])->name('products-json');
	Route::get('/products-sell', [ProductController::class, 'getAllProductsJson'])->name('all-products-json');
	Route::get('/export-products', [ProductController::class, 'exportProducts'])->name('export-products');
	Route::get('/price-tags', [ProductController::class, 'getPriceTags'])->name('price-tags');
	Route::post('/import-products', [ProductController::class, 'importProducts'])->name('import-products');
	Route::get('/view-rates', [RateController::class, 'index'])->name('view-rates');
	Route::post('/submit-rate', [RateController::class, 'store'])->name('submit-rate');
	//route that will get the rate
	Route::get('/getRate', [RateController::class, 'getRate'])->name('get-rate');
	Route::get('/view-invoices', [InvoiceController::class, 'viewInvoices'])->name('view-invoices');
	Route::get('/view-productRpt', [ReportController::class, 'viewProductRpt'])->name('view-productRpt');
	Route::get('/view-invoice/{id}', [InvoiceController::class, 'viewInvoiceById'])->name('invoice.show');
	Route::get('/summarise-invoice/{id}', [InvoiceController::class, 'summariseInvoice'])->name('invoice.summarise');
	Route::get('/delete-invoice/{id}', [InvoiceController::class, 'deleteInvoice'])->name('invoice.delete');
	//api routes
	Route::get('/all-products', [ApiController::class, 'viewAllProducts'])->name('view.products');
	Route::get('/top-selling-products', [ApiController::class, 'topSellingProducts'])->name('view.top-products');
	Route::get('/get-statistics', [ApiController::class, 'getStatistics'])->name('view.get-statistics');
	Route::get('/get-stockinfo', [ApiController::class, 'getStockInformation'])->name('get.stockinfo');
	Route::get('/get-all-customers', [ApiController::class, 'getAllCustomers'])->name('get.allcustomers');
	Route::get('/device-register', [FiscalController::class, 'registerDevice']);
	Route::post('/device-register', [FiscalController::class, 'submitDevice']);
	Route::get('/get-all-suppliers', [ApiController::class, 'getAllSuppliers'])->name('get.allsuppliers');
	Route::get('/get-all-suppliers', [ApiController::class, 'getAllSuppliers'])->name('get.allsuppliers');
	Route::get("/get-all-grvs",[ApiController::class,'getAllGRVS'])->name("getAllGrvs");
	Route::get("/add-printer",[AddPrinterController::class,'addPrinter'])->name("add-printer");
	Route::get("/view-quotations",[QuoteController::class,'viewAllQuotations'])->name("view.quotes");
	Route::get("get-employees",[ApiController::class,'getAllEmployees'])->name("getAllEmployees");
	Route::get("/test",[ApiController::class,'showResult'])->name("showResult");
	Route::get('/get-rate-json',[ApiController::class,'getRate'])->name('get-rate-json');
	Route::get('/total-sales',[ApiController::class,'getTotalSales'])->name('get-total-sales');
	Route::get('/printers', [AddPrinterController::class, 'showPrinters'])->name('printers');
	Route::post('/print-test', [AddPrinterController::class, 'printTestPage'])->name('print-test');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');


	// Device Status Route


	// Device Status Route
Route::get('/device/status', [FiscalDeviceController::class, 'getDeviceStatus']);

// Open Fiscal Day Route
Route::post('/device/openDay', [FiscalDeviceController::class, 'openFiscalDay']);

// Close Fiscal Day Route
Route::post('/device/closeDay', [FiscalDeviceController::class, 'closeFiscalDay']);

// Submit Receipt Route
Route::post('/device/submitReceipt', [FiscalDeviceController::class, 'submitReceipt']);

// Get Device Configuration Route
Route::get('/device/config', [FiscalDeviceController::class, 'getDeviceConfig']);
});