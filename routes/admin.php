<?php

use App\Http\Controllers\Admin\AccauontController;
use App\Http\Controllers\Admin\AccauontTypeController;
use App\Http\Controllers\Admin\admin__panel__settingsController;
use App\Http\Controllers\Admin\Inv_uomController;
use App\Http\Controllers\Admin\TreasuryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvItemscardCategoryController;
use App\Http\Controllers\Admin\ItemCardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SalesMaterialTypeController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\SuppliersCategoryController;
use App\Models\InvItemscardCategory;
use App\Models\SalesMaterialType;
use App\Models\SuppliersCategory;
use App\Models\Treasury_Delivery;
use Illuminate\Support\Facades\Route;

define('PAGINATION_COUNT', 5);
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])
        ->name('admin.dashboard');

    Route::get('/admin__panel__setting/index',[admin__panel__settingsController::class,'index'])->name('admin.admin__panel__setting.index');
    Route::get('/admin__panel__setting/edit',[admin__panel__settingsController::class,'edit'])->name('admin.adminpanelsetting.edit');
    Route::post('/admin__panel__setting/update',[admin__panel__settingsController::class,'update'])->name('admin.adminpanelsetting.update');
      /*start treasuries*/
    Route::get('/treasuries',[TreasuryController::class,'index'])->name('admin.treasuries.index');
    Route::get('/treasuries/create',[TreasuryController::class,'create'])->name('admin.treasuries.create');
    Route::post('/treasuries/store',[TreasuryController::class,'store'])->name('admin.treasuries.store');
    Route::get('/treasuries/edit/{id}',[TreasuryController::class,'edit'])->name('admin.treasuries.edit');
    Route::post('/treasuries/update/{id}',[TreasuryController::class,'update'])->name('admin.treasuries.update');
    Route::get('/treasuries/search',[TreasuryController::class,'search'])->name('admin.treasuries.search');
    Route::get('/treasuries/detalls/{id}',[TreasuryController::class,'detalls'])->name('admin.treasuries.detalls');
        /*end treasuries*/

        /* start-Treasury_Delivery */
        Route::get('/Treasury_Delivery/Add_Treasury_Delivery/{id}',[TreasuryController::class,'Add_Treasury_Delivery'])->name('admin.treasuries.Add_Treasury_Delivery');
        Route::post('/Treasury_Delivery/Store_Treasury_Delivery/{id}',[TreasuryController::class,'Store_Treasury_Delivery'])->name('admin.treasuries.Store_Treasury_Delivery');
        Route::get('/Treasury_Delivery/delete_Treasury_Delivery/{id}',[TreasuryController::class,'delete_Treasury_Delivery'])->name('admin.treasuries.delete_Treasury_Delivery');
        /* end-Treasury_Delivery */

        /*start-sales_material_types*/
        Route::get('/sales_material_types',[SalesMaterialTypeController::class,'index'])->name('admin.sales_material_types.index');
        Route::get('/SalesMaterialTypeController/edit/{id}',[SalesMaterialTypeController::class,'edit'])->name('admin.SalesMaterialTypeController.edit');
        Route::post('/SalesMaterialTypeController/update/{id}',[SalesMaterialTypeController::class,'update'])->name('admin.SalesMaterialTypeController.update');
        Route::get('/SalesMaterialTypeController/create',[SalesMaterialTypeController::class,'create'])->name('admin.SalesMaterialTypeController.create');
               Route::get('/SalesMaterialTypeController/search',[SalesMaterialTypeController::class,'search'])->name('admin.SalesMaterialTypeController.search');

        Route::post('/SalesMaterialTypeController/store',[SalesMaterialTypeController::class,'store'])->name('admin.SalesMaterialTypeController.store');
        Route::get('/SalesMaterialTypeController/delete_SalesMaterialTypeController/{id}',[SalesMaterialTypeController::class,'delete_SalesMaterialType'])->name('admin.delete_SalesMaterialType');
        /*end-sales_material_types*/

        /*strat-stores*/
        Route::get('/stores',[StoresController::class,'index'])->name('admin.stores.index');
        Route::get('/stores/edit/{id}',[StoresController::class,'edit'])->name('admin.stores.edit');
        Route::get('/stores/create',[StoresController::class,'create'])->name('admin.stores.create');
        Route::post('/stores/store/',[StoresController::class,'store'])->name('admin.stores.store');
        Route::post('/stores/update/{id}',[StoresController::class,'update'])->name('admin.stores.update');
        Route::get('/stores/delete_stores/{id}',[StoresController::class,'delete_stores'])->name('admin.delete_stores');
        Route::get('/stores/search',[StoresController::class,'search'])->name('admin.stores.search');

        /*end-stores*/

        /*start-Inv_uom */
        Route::get('/Inv_uom',[Inv_uomController::class,'index'])->name('admin.Inv_uom.index');
        Route::get('/Inv_uom/edit/{id}',[Inv_uomController::class,'edit'])->name('admin.Inv_uom.edit');
         Route::get('/Inv_uom/create',[Inv_uomController::class,'create'])->name('admin.Inv_uom.create');
        Route::post('/Inv_uom/store/',[Inv_uomController::class,'store'])->name('admin.Inv_uom.store');
        Route::post('/Inv_uom/update/{id}',[Inv_uomController::class,'update'])->name('admin.Inv_uom.update');
        Route::get('/Inv_uom/delete_Inv_uom/{id}',[Inv_uomController::class,'delete_Inv_uom'])->name('admin.delete_Inv_uom');
        Route::get('/Inv_uom/search',[Inv_uomController::class,'search'])->name('admin.Inv_uom.search');
        /*end-Inv_uom */

        /*start-inv_itemscard_categories*/
        Route::get('/inv_itemscard_categories/search',[InvItemscardCategoryController::class,'search'])->name('admin.inv_itemscard_categories.search');
        Route::resource('/inv_itemscard_categories',InvItemscardCategoryController::class);
        /*end-inv_itemscard_categories*/

        /*start-item_cards*/
        Route::get('/item_card/search',[ItemCardController::class,'search'])->name('admin.item_card.search');
        Route::resource('/item_card',ItemCardController::class);
        /*end-item_cards*/

        /*start-acaauont_types */
        Route::get('/acaauont_types/search',[AccauontTypeController::class,'search'])->name('admin.acaauont_types.search');
        Route::resource('/acaauont_types',AccauontTypeController::class);
        /*end-acaauont_types */

        /*start-acaauonts */
        Route::get('/acaauonts/search',[AccauontController::class,'search'])->name('admin.acaauonts.search');
        Route::resource('/acaauonts',AccauontController::class);
        /*end-acaauonts */

        /*start-customers*/
        Route::get('/customers/search',[CustomerController::class,'search'])->name('admin.customers.search');
        Route::resource('/customers',CustomerController::class);
        /*end-customers*/
        /*start-Suppliers_Category*/
        Route::get('/Suppliers_Category/search',[SuppliersCategoryController::class,'search'])->name('admin.Suppliers_Category.search');
        Route::resource('/Suppliers_Category',SuppliersCategoryController::class);
        /*end-Suppliers_Category*/
        /*start-Suppliers */
        Route::get('/Suppliers/search',[SupplierController::class,'search'])->name('admin.Suppliers.search');
        Route::resource('/Suppliers',SupplierController::class);
        /*end-Suppliers */
});
Route::get('/logout',[LoginController::class,'logout'])->name('admin.logout');
Route::get('/login', [LoginController::class, 'show_login_view'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');

