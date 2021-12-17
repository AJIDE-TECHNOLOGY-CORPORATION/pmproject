<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

use App\Http\Controllers\InstallController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminMasterController;
use App\Http\Controllers\AdminItemController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\AdminEstimateController;
use App\Http\Controllers\AdminExpenseController;
use App\Http\Controllers\AdminInvoiceController;
use App\Http\Controllers\AdminNoteController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminBankController;
use App\Http\Controllers\AdminTodoController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerTransactionController;
use App\Http\Controllers\CustomerEstimateController;
use App\Http\Controllers\CustomerInvoiceController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\AdminProjectController;
use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CustomerRazorpayController;
use App\Http\Controllers\CustomerPaypalController;

/* Installation */
Route::get('/install/start', "InstallController@install")->name('install');
Route::match(['get','post'],'/install/verification', "InstallController@verification")->name('verification');
Route::match(['get', 'post'],'/install/dbsettings', "InstallController@dbsettings")->name('dbsettings');
Route::post('/install/postDatabase', "InstallController@postDatabase")->name('postDatabase');
Route::get('/install/completed', "InstallController@install_completed")->name('install_completed');

/* Installation */
Route::get('install/update', "UpdateController@start")->name('start');

Route::post('update/start', [UpdateController::class, 'update']);

/* admin - login and logout */
Route::match(['get', 'post'],'/admin', [LoginController::class, 'doAdminLogin'])->name('admin-login');
Route::get('/admin-logout', [LoginController::class, 'adminLogout'])->name('admin-logout');


/* customer- login and logout */
Route::get('/', [LoginController::class, 'doCustomerLogin']);
Route::match(['get', 'post'],'/customer', [LoginController::class, 'doCustomerLogin'])->name('customer-login');
Route::get('/customer-logout', [LoginController::class, 'customerLogout'])->name('customer-logout');

/* admin management section */
Route::group(['prefix' => 'admin','middleware' => 'admin'], function () {

    /* admin dashboard */
    Route::get('dashboard', [AdminDashboardController::class, 'dashboard']);

    /* check unique email */
    Route::match(['get', 'post'], '/checkEmail', [AdminDashboardController::class, 'checkEmail']);

    /* Customer management */
    Route::group(['prefix' => 'customers'], function () {
        Route::get('/', [AdminCustomerController::class, 'customersIndex']);
        Route::match(['get', 'post'], '/create', [AdminCustomerController::class, 'createCustomer']);
        Route::match(['get', 'post'], '/update/{id}', [AdminCustomerController::class, 'updateCustomer']);
        Route::get('/delete/{id}', [AdminCustomerController::class, 'destroyCustomer']);
        Route::get('/show/{id}', [AdminCustomerController::class, 'show']);
        Route::get('/updateStatus', [AdminCustomerController::class, 'updateStatus']);
        Route::match(['get', 'post'], 'remove-image/{id}', [AdminCustomerController::class, 'remove_image']);
    });

    /* master settings */
    Route::group(['prefix' => 'masters'], function () {
        Route::match(['get', 'post'], '/account', [AdminMasterController::class, 'mastersAccountIndex']);
        Route::match(['get', 'post'],'/company', [AdminMasterController::class, 'mastersCompanyIndex']);
        Route::match(['get', 'post'],'/preference', [AdminMasterController::class, 'mastersPreferenceIndex']);
        Route::match(['get', 'post'],'/email', [AdminMasterController::class, 'mastersEmailIndex']);
        Route::match(['get', 'post'], '/payment', [AdminMasterController::class, 'mastersPaymentIndex']);

        Route::group(['prefix' => 'expense-category'], function () {
            Route::match(['get', 'post'],'/', [AdminMasterController::class, 'expenseCategoryIndex']);
            Route::match(['get', 'post'], '/update/{id}', [AdminMasterController::class, 'updateExpenseCategory']);
            Route::get('/delete/{id}', [AdminMasterController::class, 'destroyExpenseCategory']);
        });

        Route::group(['prefix' => 'tax'], function () {
            Route::match(['get', 'post'],'/', [AdminMasterController::class, 'taxIndex']);
            Route::match(['get', 'post'], '/update/{id}', [AdminMasterController::class, 'updateTax']);
            Route::get('/delete/{id}', [AdminMasterController::class, 'destroyTax']);
        });

        Route::group(['prefix' => 'payment-mode'], function () {
            Route::match(['get', 'post'],'/', [AdminMasterController::class, 'paymentModeIndex']);
            Route::match(['get', 'post'], '/update/{id}', [AdminMasterController::class, 'updatePaymentMode']);
            Route::get('/delete/{id}', [AdminMasterController::class, 'destroyPaymentMode']);
        });
    });

    /* item management */
    Route::group(['prefix' => 'items'], function () {
        Route::match(['get', 'post'], '/', [AdminItemController::class, 'itemsIndex']);
        Route::match(['get', 'post'], '/update/{id}', [AdminItemController::class, 'updateItem']);
        Route::get('/delete/{id}', [AdminItemController::class, 'destroyItem']);
    });


    /* get estimate information */
    Route::group(['prefix' => 'estimates'], function () {
        Route::match(['get', 'post'], '/', [AdminEstimateController::class, 'estimatesIndex']);
        Route::match(['get', 'post'], '/create', [AdminEstimateController::class, 'createEstimate']);
        Route::match(['get', 'post'], '/update/{id}', [AdminEstimateController::class, 'updateEstimate']);
        Route::get('/delete/{id}', [AdminEstimateController::class, 'destroyEstimate']);
        Route::get('/show/{id}', [AdminEstimateController::class, 'showEstimate']);
        Route::get('get-customer/{id}', [AdminEstimateController::class, 'getCustomerDetail']);
        Route::get('get-product/{id}', [AdminEstimateController::class, 'getProductDetail']);
        Route::get('get-estimate-product/{estimate_id}', [AdminEstimateController::class, 'getEstimateDetails']);
    });

    /* get invoice information */
    Route::group(['prefix' => 'invoices'], function () {
        Route::match(['get', 'post'], '/', [AdminInvoiceController::class, 'invoicesIndex']);
        Route::match(['get', 'post'], '/create', [AdminInvoiceController::class, 'createInvoice']);
        Route::match(['get', 'post'], '/update/{id}', [AdminInvoiceController::class, 'updateInvoice']);
        Route::get('/delete/{id}', [AdminInvoiceController::class, 'destroyInvoice']);
        Route::get('get-customer/{id}', [AdminInvoiceController::class, 'getCustomerDetail']);
        Route::get('get-product/{id}', [AdminInvoiceController::class, 'getProductDetail']);
        Route::get('get-invoice-product/{invoice_id}', [AdminInvoiceController::class, 'getInvoiceProductDetail']);
        Route::get('/show/{id}', [AdminInvoiceController::class, 'showInvoice']);
        Route::post('/send-payment-link', [AdminInvoiceController::class, 'sendPaymentLink']);
        Route::get('/downloadPdf',  [AdminInvoiceController::class, 'downloadPdf']);

    });

    /* order information */
    Route::group(['prefix' => 'orders'], function () {
        Route::match(['get', 'post'], '/', [AdminOrderController::class, 'ordersIndex']);
        Route::get('/show/{id}', [AdminOrderController::class, 'showOrder']);
        Route::get('get-order-product/{order_id}', [AdminOrderController::class, 'getOrderProductDetail']);
        Route::get('change-order-status', [AdminOrderController::class, 'changeOrderStatus']);
        Route::get('/convert_to_invoice',  [AdminOrderController::class, 'convertToInvoice']);
    });

    /* get payment transaction information */
    Route::group(['prefix' => 'payments'], function () {
        Route::match(['get', 'post'], '/', [AdminTransactionController::class, 'paymentsIndex']);
        Route::match(['get', 'post'], '/create', [AdminTransactionController::class, 'createPayment']);
        Route::match(['get', 'post'], '/update/{id}', [AdminTransactionController::class, 'updatePayment']);
        Route::get('/delete/{id}', [AdminTransactionController::class, 'destroyPayment']);
        Route::get('get-invoice/{invoice_number}', [AdminTransactionController::class, 'getInvoiceDetail']);
    });

    /*get expense information*/
    Route::group(['prefix' => 'expenses'], function () {
        Route::match(['get', 'post'], '/', [AdminExpenseController::class, 'expensesIndex']);
        Route::match(['get', 'post'], '/create', [AdminExpenseController::class, 'createExpense']);
        Route::match(['get', 'post'], '/update/{id}', [AdminExpenseController::class, 'updateExpense']);
        Route::get('/delete/{id}', [AdminExpenseController::class, 'destroyExpense']);
    });

     /*get notes information*/
     Route::group(['prefix' => 'notes'], function () {
        Route::match(['get', 'post'], '/', [AdminNoteController::class, 'notesIndex']);
        Route::match(['get', 'post'], '/create', [AdminNoteController::class, 'createNotes']);
        Route::match(['get', 'post'], '/update/{id}', [AdminNoteController::class, 'updateNotes']);
        Route::get('/delete/{id}', [AdminNoteController::class, 'destroyNotes']);
    });

    /* bank management */
    Route::group(['prefix' => 'bank'], function () {
    /*get accounts information*/
    Route::group(['prefix' => 'accounts'], function () {
        Route::match(['get', 'post'], '/', [AdminBankController::class, 'accountsIndex']);
        Route::match(['get', 'post'], '/create', [AdminBankController::class, 'createAccounts']);
        Route::match(['get', 'post'], '/update/{id}', [AdminBankController::class, 'updateAccounts']);
        Route::get('/delete/{id}', [AdminBankController::class, 'destroyAccounts']);
    });

    Route::group(['prefix' => 'transfer'], function () {
        Route::match(['get', 'post'], '/', [AdminBankController::class, 'transferIndex']);
        Route::match(['get', 'post'], '/create', [AdminBankController::class, 'createTransfer']);
        Route::match(['get', 'post'], '/update/{id}', [AdminBankController::class, 'updateTransfer']);
        Route::get('/delete/{id}', [AdminBankController::class, 'destroyTransfer']);
    });

});

    /*todo management*/
    Route::group(['prefix' => 'todos'], function () {
        Route::match(['get', 'post'], '/', [AdminTodoController::class, 'todosIndex']);
        Route::match(['get', 'post'], '/create', [AdminTodoController::class, 'createTodo']);
        Route::match(['get', 'post'], '/update/{id}', [AdminTodoController::class, 'updateTodo']);
        Route::get('/delete/{id}', [AdminTodoController::class, 'destroyTodo']);
        Route::get('change-status', [AdminTodoController::class, 'changeStatus']);
    });


    /* Report management */
    Route::group(['prefix' => 'reports'], function () {
        Route::match(['get', 'post'],'/invoice', [AdminReportController::class, 'invoiceReportIndex']);
        Route::match(['get', 'post'],'/customers', [AdminReportController::class, 'customerReportIndex']);
    });

       /* online transaction listing */
       Route::group(['prefix' => 'online-transactions'], function () {
        Route::get('/', [AdminTransactionController::class, 'onlineTransactionsIndex']);
       });

    /*project management*/
    Route::group(['prefix' => 'projects'], function () {
        Route::match(['get', 'post'], '/', [AdminProjectController::class, 'projectsIndex']);
        Route::match(['get', 'post'], '/create', [AdminProjectController::class, 'createProject']);
        Route::match(['get', 'post'], '/update/{id}', [AdminProjectController::class, 'updateProject']);
        Route::get('/delete/{id}', [AdminProjectController::class, 'destroyProject']);
    });

    /*Task management*/
    Route::group(['prefix' => 'tasks'], function () {
        Route::match(['get', 'post'], '/', [AdminTaskController::class, 'tasksIndex']);
        Route::match(['get', 'post'], '/create', [AdminTaskController::class, 'createTask']);
        Route::match(['get', 'post'], '/update/{id}', [AdminTaskController::class, 'updateTask']);
        Route::get('/delete/{id}', [AdminTaskController::class, 'destroyTask']);
        Route::get('change-status', [AdminTaskController::class, 'changeStatus']);
    });

});

Route::group(['prefix' => 'customer/invoices'], function () {
    Route::get('/stripe/{id}/{email}', [CustomerPaymentController::class, 'showStripeInvoice']);
    Route::get('/stripe-payment/{id}/{email}', [CustomerPaymentController::class, 'showStripe']);
    Route::get('/razorpay-payment/{id}/{email}', [CustomerRazorpayController::class, 'showRazorpay']);
    Route::post('/pay-success', [CustomerRazorpayController::class, 'razorPaySuccess']);
    Route::get('/paypal/{id}/{email}', [CustomerPayPalController::class, 'showPaypalInvoice']);
    Route::post('/paypal-payment', [CustomerPaypalController::class, 'showPaypal']);

    Route::post('create-paypal-transaction', 'PaymentController@createPayment');
    Route::post('confirm-paypal-transaction', 'PaymentController@confirmPayment');

});

Route::post('save_seess', [CustomerPaymentController::class, 'save_seess']);
Route::post('stripe', [CustomerPaymentController::class, 'stripePost'])->name('stripe.post');


/* customer Section */
Route::group(['prefix' => 'customer', 'middleware' => 'customer'], function () {

    /* customer dashboard */
    Route::get('dashboard', [CustomerDashboardController::class, 'dashboard']);

    /* check unique email */
    Route::match(['get', 'post'], '/checkEmail', [CustomerDashboardController::class, 'checkEmail']);

    /*edit profile */
    Route::match(['get','post'], '/edit-profile/{id}', [CustomerDashboardController::class, 'editProfile']);

    /* get estimate information */
    Route::group(['prefix' => 'estimates'], function () {
        Route::match(['get', 'post'], '/', [CustomerEstimateController::class, 'estimatesIndex']);
        Route::get('/show/{id}', [CustomerEstimateController::class, 'showEstimate']);
        Route::get('get-estimate-product/{estimate_id}', [CustomerEstimateController::class, 'getEstimateDetails']);
    });

    /* get invoice information */
    Route::group(['prefix' => 'invoices'], function () {
        Route::match(['get', 'post'], '/', [CustomerInvoiceController::class, 'invoicesIndex'])->name('invoice');
        Route::get('/show/{id}', [CustomerInvoiceController::class, 'showInvoice']);
        Route::get('get-invoice-product/{invoice_id}', [CustomerInvoiceController::class, 'getInvoiceProductDetail']);
        Route::get('/downloadPdf',  [CustomerInvoiceController::class, 'downloadPdf']);
    });

    /* get payment transaction information */
    Route::group(['prefix' => 'payments'], function () {
        Route::match(['get', 'post'], '/', [CustomerTransactionController::class, 'paymentsIndex']);
    });

    /* get order information */
    Route::group(['prefix' => 'orders'], function () {
        Route::match(['get', 'post'], '/', [CustomerOrderController::class, 'ordersIndex']);
        Route::match(['get', 'post'], '/create', [CustomerOrderController::class, 'createOrder']);
        Route::match(['get', 'post'], '/update/{id}', [CustomerOrderController::class, 'updateOrder']);
        Route::get('get-product/{id}', [CustomerOrderController::class, 'getProductDetail']);
        Route::get('get-order-product/{order_id}', [CustomerOrderController::class, 'getOrderProductDetail']);
        Route::get('/show/{id}', [CustomerOrderController::class, 'showOrder']);
    });
});
