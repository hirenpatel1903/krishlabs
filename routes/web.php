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









Route::group(['middleware' => ['installed']], function () {

    require __DIR__.'/auth.php';

});

Route::group(['prefix' => 'install', 'as' => 'LaravelInstaller::', 'middleware' => ['web', 'install']], function () {

    Route::post('environment/saveWizard', [

        'as'   => 'environmentSaveWizard',

        'uses' => 'EnvironmentController@saveWizard',

    ]);



    Route::get('environment/classic', [

        'as' => 'environmentClassic',

        'uses' => 'EnvironmentController@environmentClassic',

    ]);



    Route::get('purchase-code', [

        'as'   => 'purchase_code',

        'uses' => 'PurchaseCodeController@index',

    ]);



    Route::post('purchase-code', [

        'as'   => 'purchase_code.check',

        'uses' => 'PurchaseCodeController@action',

    ]);



    Route::get('final', [

        'as' => 'final',

        'uses' => 'FinalController@finish',

    ]);

});





Route::get('/home', 'CheckInController@index')->name('home');



Route::group(['middleware' => ['installed']], function () {

    Route::get('/', 'CheckInController@index')->name('/');



    Route::get('/check-in/create-step-one', ['as' => 'check-in.step-one', 'uses' => 'CheckInController@createStepOne']);

    Route::post('/check-in/create-step-one', ['as' => 'check-in.step-one.store', 'uses' => 'CheckInController@postCreateStepOne']);



    Route::get('/customer/check-balance', ['as' => 'check-balance', 'uses' => 'CustomerController@index']);

    Route::post('/customer/check-balance', ['as' => 'check-balance', 'uses' => 'CustomerController@checkBalance']);



});





Route::group(['prefix' => 'admin', 'middleware' => ['auth','installed'], 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    Route::get('/', 'DashboardController@index')->name('home');



    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

    Route::post('day-wise-income-sale', 'DashboardController@dayWiseIncomeSale')->name('dashboard.day-wise-income-sale');



    Route::get('profile', 'ProfileController@index')->name('profile');

    Route::put('profile/update/{profile}', 'ProfileController@update')->name('profile.update');

    Route::put('profile/change', 'ProfileController@change')->name('profile.change');





    Route::resource('category', 'CategoryController');

    Route::get('get-category', 'CategoryController@getCategory')->name('category.get-category');



    Route::resource('unit', 'UnitController');

    Route::get('unit.get-unit', 'UnitController@getUnit')->name('unit.get-unit');



    Route::resource('tax', 'TaxController');

    Route::get('unit.get-tax', 'TaxController@getTax')->name('tax.get-tax');



    Route::resource('administrators', 'AdministratorController');

    Route::get('get-administrators', 'AdministratorController@getAdministrators')->name('administrators.get-administrators');



    Route::resource('customers', 'CustomerController');

    Route::get('get-customers', 'CustomerController@getCustomers')->name('customers.get-customers');



    Route::resource('deposit', 'DepositController');

    Route::get('get-deposit', 'DepositController@getDeposit')->name('deposit.get-deposit');



    Route::resource('shop', 'ShopController');

    Route::get('get-shop', 'ShopController@getShop')->name('shop.get-shop');



    Route::resource('products', 'ProductController');

    Route::get('get-products', 'ProductController@getProduct')->name('products.get-product');



    Route::post('shop-category', 'ProductController@getCategory')->name('shop-category');

    Route::post('shop-unit', 'ProductController@getUnit')->name('shop-unit');

    Route::post('shop-tax', 'ProductController@getTax')->name('shop-tax');





    Route::get('barcode', 'ProductController@barcode')->name('products.barcode');

    Route::post('get-product-variants', 'ProductController@getVariants')->name('get-product-variants');

    Route::post('barcode', 'ProductController@barcode')->name('barcode.print');







    Route::resource('stock', 'StockController');

    Route::get('get-stock', 'StockController@getStock')->name('stock.get-stock');



    Route::resource('sale', 'SalesController');

    Route::get('get-sale', 'SalesController@getSales')->name('sale.get-sale');

    Route::post('select-shop', 'SalesController@shop')->name('select-shop.shop');

    Route::get('change-shop', 'SalesController@changeShop')->name('change-shop.shop');





    Route::get('pos', 'SalesController@create')->name('pos');

    Route::post('pos', 'SalesController@store')->name('pos.store');

    Route::get('/pos/view/{sale}', 'SalesController@posPrint')->name('pos.view');





    Route::resource('purchase', 'PurchaseController');

    Route::get('get-purchase', 'PurchaseController@getPurchase')->name('purchase.get-purchase');

    Route::post('product-variants', 'PurchaseController@getVariants')->name('product-variants');

    Route::post('shop-product', 'PurchaseController@getShopProduct')->name('shop-product');





    Route::get('sales-report', 'ReportController@saleReport')->name('sales-report.index');

    Route::post('sales-report', 'ReportController@saleReport')->name('sales-report.index');



    Route::get('purchases-report', 'ReportController@purchaseReport')->name('purchases-report.index');

    Route::post('purchases-report', 'ReportController@purchaseReport')->name('purchases-report.index');



    Route::get('stock-report', 'ReportController@stockReport')->name('stock-report.index');

    Route::post('stock-report', 'ReportController@stockReport')->name('stock-report.index');



    Route::resource('role', 'RoleController');

    Route::post('get-role-user', 'CreditBalanceReportController@getUsers')->name('get-role-user');

    Route::post('role/save-permission/{id}', 'RoleController@savePermission')->name('role.save-permission');



    Route::resource('language', 'LanguageController');

    Route::get('language/change-status/{id}/{status}', 'LanguageController@changeStatus')->name('language.change-status');



    Route::resource('addons', 'AddonController');

    

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {

        Route::get('/', 'SettingController@index')->name('index');

        Route::post('/', 'SettingController@siteSettingUpdate')->name('site-update');

        Route::get('email', 'SettingController@emailSetting')->name('email');

        Route::post('email', 'SettingController@emailSettingUpdate')->name('email-update');

        Route::get('sms', 'SettingController@smsSetting')->name('sms');

        Route::post('sms', 'SettingController@smsSettingUpdate')->name('sms-update');

        Route::get('payment', 'SettingController@paymentSetting')->name('payment');

        Route::post('payment', 'SettingController@paymentSettingUpdate')->name('payment-update');



        Route::get('whatsapp', 'SettingController@whatsAppSetting')->name('whatsapp');

        Route::post('whatsapp', 'SettingController@whatsAppSettingUpdate')->name('whatsapp-update');



        Route::get('purchasekey', 'SettingController@purchaseKeySetting')->name('purchasekey');

        Route::post('purchasekey', 'SettingController@purchaseKeySettingUpdate')->name('purchasekey-update');

        



    });

});

