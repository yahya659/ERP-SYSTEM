<?php
use App\Http\Controllers\Admin\AccauontController;
use App\Http\Controllers\Admin\AccauontTypeController;
use App\Http\Controllers\Admin\admin__panel__settingsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminShiftController;
use App\Http\Controllers\Admin\Inv_uomController;
use App\Http\Controllers\Admin\TreasuryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InvItemscardCategoryController;
use App\Http\Controllers\Admin\ItemCardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SalesMaterialTypeController;
use App\Http\Controllers\Admin\StoresController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DelegatesController;
use App\Http\Controllers\Admin\ExchangeController;
use App\Http\Controllers\Admin\ItemCardBalancesController;
use App\Http\Controllers\Admin\SalesInvoiceController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\Suppliers_with_ordersGenralReturnController;
use App\Http\Controllers\Admin\SuppliersCategoryController;
use App\Http\Controllers\Admin\SupplierWithOrderController;
use App\Http\Controllers\Admin\TreasuriesTransactionController;
use Illuminate\Support\Facades\Route;

define('PAGINATION_COUNT', 10);
    Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard',[DashboardController::class,'index'])
        ->name('admin.dashboard');

    Route::get('/admin__panel__setting/index',[admin__panel__settingsController::class,'index'])->name('admin.admin__panel__setting.index');
    Route::get('/admin__panel__setting/edit',[admin__panel__settingsController::class,'edit'])->name('admin.adminpanelsetting.edit');
    Route::post('/admin__panel__setting/update',[admin__panel__settingsController::class,'update'])->name('admin.adminpanelsetting.update');
    // ------------------------------------------------------------------------------------
      /*start treasuries*/
    Route::get('/treasuries',[TreasuryController::class,'index'])->name('admin.treasuries.index');
    Route::get('/treasuries/create',[TreasuryController::class,'create'])->name('admin.treasuries.create');
    Route::post('/treasuries/store',[TreasuryController::class,'store'])->name('admin.treasuries.store');
    Route::get('/treasuries/edit/{id}',[TreasuryController::class,'edit'])->name('admin.treasuries.edit');
    Route::post('/treasuries/update/{id}',[TreasuryController::class,'update'])->name('admin.treasuries.update');
    Route::get('/treasuries/search',[TreasuryController::class,'search'])->name('admin.treasuries.search');
    Route::get('/treasuries/detalls/{id}',[TreasuryController::class,'detalls'])->name('admin.treasuries.detalls');
        /*end treasuries*/
        // --------------------------------------------------------
        /* start-Treasury_Delivery */
        Route::get('/Treasury_Delivery/Add_Treasury_Delivery/{id}',[TreasuryController::class,'Add_Treasury_Delivery'])->name('admin.treasuries.Add_Treasury_Delivery');
        Route::post('/Treasury_Delivery/Store_Treasury_Delivery/{id}',[TreasuryController::class,'Store_Treasury_Delivery'])->name('admin.treasuries.Store_Treasury_Delivery');
        Route::get('/Treasury_Delivery/delete_Treasury_Delivery/{id}',[TreasuryController::class,'delete_Treasury_Delivery'])->name('admin.treasuries.delete_Treasury_Delivery');
        /* end-Treasury_Delivery */
        // -------------------------------------------------------
        /*start-sales_material_types*/
        Route::get('/sales_material_types',[SalesMaterialTypeController::class,'index'])->name('admin.sales_material_types.index');
        Route::get('/SalesMaterialTypeController/edit/{id}',[SalesMaterialTypeController::class,'edit'])->name('admin.SalesMaterialTypeController.edit');
        Route::post('/SalesMaterialTypeController/update/{id}',[SalesMaterialTypeController::class,'update'])->name('admin.SalesMaterialTypeController.update');
        Route::get('/SalesMaterialTypeController/create',[SalesMaterialTypeController::class,'create'])->name('admin.SalesMaterialTypeController.create');
               Route::get('/SalesMaterialTypeController/search',[SalesMaterialTypeController::class,'search'])->name('admin.SalesMaterialTypeController.search');

        Route::post('/SalesMaterialTypeController/store',[SalesMaterialTypeController::class,'store'])->name('admin.SalesMaterialTypeController.store');
        Route::get('/SalesMaterialTypeController/delete_SalesMaterialTypeController/{id}',[SalesMaterialTypeController::class,'delete_SalesMaterialType'])->name('admin.delete_SalesMaterialType');
        /*end-sales_material_types*/
        // ----------------------------------------------------
        /*strat-stores*/
        Route::get('/stores',[StoresController::class,'index'])->name('admin.stores.index');
        Route::get('/stores/edit/{id}',[StoresController::class,'edit'])->name('admin.stores.edit');
        Route::get('/stores/create',[StoresController::class,'create'])->name('admin.stores.create');
        Route::post('/stores/store/',[StoresController::class,'store'])->name('admin.stores.store');
        Route::post('/stores/update/{id}',[StoresController::class,'update'])->name('admin.stores.update');
        Route::get('/stores/delete_stores/{id}',[StoresController::class,'delete_stores'])->name('admin.delete_stores');
        Route::get('/stores/search',[StoresController::class,'search'])->name('admin.stores.search');

        /*end-stores*/
        // ----------------------------------------------------------------
        /*start-Inv_uom */
        Route::get('/Inv_uom',[Inv_uomController::class,'index'])->name('admin.Inv_uom.index');
        Route::get('/Inv_uom/edit/{id}',[Inv_uomController::class,'edit'])->name('admin.Inv_uom.edit');
         Route::get('/Inv_uom/create',[Inv_uomController::class,'create'])->name('admin.Inv_uom.create');
        Route::post('/Inv_uom/store/',[Inv_uomController::class,'store'])->name('admin.Inv_uom.store');
        Route::post('/Inv_uom/update/{id}',[Inv_uomController::class,'update'])->name('admin.Inv_uom.update');
        Route::get('/Inv_uom/delete_Inv_uom/{id}',[Inv_uomController::class,'delete_Inv_uom'])->name('admin.delete_Inv_uom');
        Route::get('/Inv_uom/search',[Inv_uomController::class,'search'])->name('admin.Inv_uom.search');
        /*end-Inv_uom */
        // -------------------------------------------------------------------
        /*start-inv_itemscard_categories*/
        Route::get('/inv_itemscard_categories/search',[InvItemscardCategoryController::class,'search'])->name('admin.inv_itemscard_categories.search');
        Route::resource('/inv_itemscard_categories',InvItemscardCategoryController::class);
        /*end-inv_itemscard_categories*/
        // -----------------------------------------------------------
        /*start-item_cards*/
        Route::get('/item_card/search',[ItemCardController::class,'search'])->name('admin.item_card.search');
        Route::resource('/item_card',ItemCardController::class);
        /*end-item_cards*/
        // --------------------------------------------------
        /*start-acaauont_types */
        Route::get('/acaauont_types/search',[AccauontTypeController::class,'search'])->name('admin.acaauont_types.search');
        Route::resource('/acaauont_types',AccauontTypeController::class);
        /*end-acaauont_types */
        // -----------------------------------------------------
        /*start-acaauonts */
        Route::get('/acaauonts/search',[AccauontController::class,'search'])->name('admin.acaauonts.search');
        Route::resource('/acaauonts',AccauontController::class);
        /*end-acaauonts */
        // ---------------------------------------------------------
        /*start-customers*/
        Route::get('/customers/search',[CustomerController::class,'search'])->name('admin.customers.search');
        Route::resource('/customers',CustomerController::class);
        /*end-customers*/
        // --------------------------------------------------------------
        /*start-Suppliers_Category*/
        Route::get('/Suppliers_Category/search',[SuppliersCategoryController::class,'search'])->name('admin.Suppliers_Category.search');
        Route::resource('/Suppliers_Category',SuppliersCategoryController::class);
        /*end-Suppliers_Category*/
        // ------------------------------------------------------------
        /*start-Suppliers */
        Route::get('/Suppliers/search',[SupplierController::class,'search'])->name('admin.Suppliers.search');
        Route::resource('/Suppliers',SupplierController::class);
        /*end-Suppliers */
        // ---------------------------------------------------------
        /*start-suppliers_with_orders المشتريات*/
        Route::get('/SupplierWithOrder/search', [SupplierWithOrderController::class, 'search'])->name('SupplierWithOrder.search');
        Route::resource('/SupplierWithOrder',SupplierWithOrderController::class);
        Route::post('/SupplierWithOrder/add_new_details',[SupplierWithOrderController::class,'add_new_details'])->name('admin.Suppliers.add_new_details');
        Route::get('/SupplierWithOrder/detail/{id}/edit',[SupplierWithOrderController::class,'editdetail'])->name('SupplierWithOrder.editdetail');
        Route::delete('/SupplierWithOrderDetail/{id}', [SupplierWithOrderController::class, 'destroyDetail'])->name('SupplierWithOrder.destroyDetail');
        Route::put('/SupplierWithOrderDetail/{id}', [SupplierWithOrderController::class, 'updateDetail'])->name('SupplierWithOrder.updateDetail');
        Route::post('/SupplierWithOrder/load_approve_invoice',[SupplierWithOrderController::class,'load_approve_invoice'])->name('admin.Suppliers.load_approve_invoice');
        // اعتماد الفاتوره
        Route::post('/SupplierWithOrder/approve_invoice/{id}', [SupplierWithOrderController::class, 'approve_invoice'])->name('SupplierWithOrder.approve');

        Route::get('SupplierWithOrder/search',[SupplierWithOrderController::class, 'search'])->name('SupplierWithOrder.search');
        /*end-suppliers_with_orders */
        // -----------------------------------------------
        /* start-admin_accuont*/
        // Route::get('/admin_accauonts/search', [AdminController::class, 'search'])->name('admin_accauonts.search');
        Route::resource('/admin_accauonts',AdminController::class);
        Route::get('/admin_accauonts/detalls/{id}',[AdminController::class,'detalls'])->name('admin_accauonts.detalls');
        Route::post('/admin_accauonts/add_new_admin_treasuries',[AdminController::class,'add_new_admin_treasuries'])->name('admin_accauonts.add_new_admin_treasuries');
        /* end-admin_accuont*/
        // ---------------------------------------------------------
        /*start-admins_shift*/
        // Route::get('/admins_shift/search', [AdminShiftController::class, 'search'])->name('admins_shift.search');
        Route::resource('/admins_shift',AdminShiftController::class);
        /*end--admins_shift*/
        // --------------------------------------------------------------
        /*start--TreasuriesTransaction*/
        Route::get(
    '/TreasuriesTransaction/search/{auto_serial}',
    [TreasuriesTransactionController::class, 'searchBySerial']
)->name('TreasuriesTransaction.searchBySerial');
        Route::resource('/TreasuriesTransaction',TreasuriesTransactionController::class);
        /*end--TreasuriesTransaction*/
        // -------------------------------------------------------------------------------
        /*start--ExchangeController الصرف */
        Route::resource('/Exchange',ExchangeController::class);
        /*end-- ExchangeController الصرف */
        // -----------------------------------------------------------------------------
        /*start-Sales_Invoice فاتوره المبيعات للعلاء*/
        Route::get('/Sales_Invoice/search', [SalesInvoiceController::class,'search'])
        ->name('Sales_Invoice.search');
         Route::post(
        '/Sales_Invoice/add-item',
      [SalesInvoiceController::class, 'addItemToInvoice']
        )->name('Sales_Invoice.addItem');
// اعتماد فاتوره لمبيعات
   Route::put( '/Sales_Invoice/{id}/approve',
    [SalesInvoiceController::class, 'sales_approve_invoice']
)->name('Sales_Invoice.approve');
// حذف الصنف قبل الااعتماد
        Route::delete('/Sales_Invoice/delete-item/{id}',[SalesInvoiceController::class, 'deleteItem'])->name('Sales_Invoice.deleteItem');
        Route::resource('/Sales_Invoice',SalesInvoiceController::class);

        /*end-Sales_Invoice فاتوره المبيعات للعلاء*/
        // -----------------------------------------------------------------------------
        /*start-delegates-المناديب*/
         Route::get('/Delegates/search', [DelegatesController::class,'search'])
        ->name('admin.Delegates.search');
        Route::resource('/Delegates', DelegatesController::class);
        /*end-delegates-المناديب*/
        // -----------------------------------------------------------------------------
        /*start- suppliers_with_ordersGenralReturn مرتجع المشتريات عام*/
         Route::get('suppliers_with_ordersGenralReturn/search',[Suppliers_with_ordersGenralReturnController::class, 'search'])->name('suppliers_with_ordersGenralReturn.search');
         Route::post('/suppliers_with_ordersGenralReturn/add_new_details',[Suppliers_with_ordersGenralReturnController::class,'add_new_details'])->name('admin.suppliers_with_ordersGenralReturn.add_new_details');
         Route::delete('/suppliers_with_ordersGenralReturn/destroyDetail/{id}', [Suppliers_with_ordersGenralReturnController::class, 'destroyDetail'])->name('suppliers_with_ordersGenralReturn.destroyDetail');
        Route::post('/suppliers_with_ordersGenralReturn/approve_invoice/{id}', [Suppliers_with_ordersGenralReturnController::class, 'approve_invoice'])->name('Suppliers_with_ordersGenralReturn.approve');
        Route::get('/suppliers_with_ordersGenralReturn/detail/{id}/edit',[Suppliers_with_ordersGenralReturnController::class,'editdetail'])->name('Suppliers_with_ordersGenralReturn.editdetail');
        Route::PUT('/suppliers_with_ordersGenralReturn/updateDetail/{id}', [Suppliers_with_ordersGenralReturnController::class,'updateDetail'])->name('Suppliers_with_ordersGenralReturn.updateDetail');
Route::get(
    '/suppliers_with_ordersGenralReturn/get-batches/{item_code}',
    [Suppliers_with_ordersGenralReturnController::class, 'getItemBatches']
)->name('suppliers_with_ordersGenralReturn.getItemBatches');
                // عشان الراوت كبير الحروف اضطرينا نعمل بارميتر عشان يقبل الاااسم  الراوت
 Route::resource('suppliers_with_ordersGenralReturn',suppliers_with_ordersGenralReturnController::class)->parameters(['suppliers_with_ordersGenralReturn' => 'id']);
                /*end- suppliers_with_ordersGenralReturn مرتجع المشتريات عام*/
        // -----------------------------------------------------------------------------
        // start-itemvardbuluanse-ارصده الاااصناف
            Route::get('/itemcardbalances/search', [ItemCardBalancesController::class,'search'])
        ->name('itemcardbalances.search');
        Route::resource('/itemcardbalances',ItemCardBalancesController::class);

        // end-itemvardbuluanse-ارصده الاااصناف
        // -----------------------------------------------------------------------------
        });
Route::get('/logout',[LoginController::class,'logout'])->name('admin.logout');
Route::get('/login', [LoginController::class, 'show_login_view'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('admin.login');
