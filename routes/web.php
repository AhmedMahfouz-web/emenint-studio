<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('front.home');
})->name('home');

Route::get('/studio', function () {
    return view('front.pages.about');
})->name('about');

Route::get('/projects', function () {
    return view('front.pages.projects');
})->name('projects');

Route::get('/services/branding', function () {
    return view('front.pages.branding');
})->name('branding');

Route::get('/services/marketing', function () {
    return view('front.pages.services.marketing');
})->name('marketing');

Route::get('/services/advertising', function () {
    return view('front.pages.services.advertising');
})->name('advertising');

Route::get('/services/websites-&-application-development', function () {
    return view('front.pages.services.development');
})->name('development');

Route::get('/services/ecommerce', function () {
    return view('front.pages.services.ecommerce');
})->name('ecommerce');

Route::get('/services/consultant', function () {
    return view('front.pages.services.consultant');
})->name('consultant');

Route::get('/contact-us', function () {
    return view('front.pages.contact');
})->name('contact');

Route::get('/project/loja', function () {
    return view('front.pages.projects.loja');
})->name('loja');

Route::get('/project/zenda', function () {
    return view('front.pages.projects.zenda');
})->name('zenda');

Route::get('/project/plaza_gardens', function () {
    return view('front.pages.projects.plaza_gardens');
})->name('plaza_gardens');

Route::get('/project/esomo', function () {
    return view('front.pages.projects.esomo');
})->name('esomo');

Route::get('/project/mawish_elmasey', function () {
    return view('front.pages.projects.mawish_elmasey');
})->name('mawish_elmasey');

Route::get('/project/mentor', function () {
    return view('front.pages.projects.mentor');
})->name('mentor');

Route::get('/project/mountain_gate', function () {
    return view('front.pages.projects.mountain_gate');
})->name('mountain_gate');

Route::get('/project/oracal', function () {
    return view('front.pages.projects.oracal');
})->name('oracal');

Route::get('/project/regal', function () {
    return view('front.pages.projects.regal');
})->name('regal');

Route::get('/project/ouda_w_sala', function () {
    return view('front.pages.projects.ouda_w_sala');
})->name('ouda_w_sala');

Route::get('/project/profit', function () {
    return view('front.pages.projects.profit');
})->name('profit');

Route::get('/project/artal', function () {
    return view('front.pages.projects.artal');
})->name('artal');

Route::post('/send_mail', [mailController::class, 'send_mail'])->name('send mail');

Route::group(['prefix' => 'admin'], function () {
    Route::get('login', [UserController::class, 'get_login'])->name('get login');
    Route::post('login', [UserController::class, 'post_login'])->name('post login');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/', [Controller::class, 'index'])->name('admin_home');

        Route::get('/blog', [BlogController::class, 'index'])->name('blogs');
        Route::post('/blog', [BlogController::class, 'store'])->name('add blog');
    });
});

// Dashboard as home page
Route::group(['prefix' => 'invoice', 'middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('invoices', InvoiceController::class);
    Route::resource('quotations', QuotationController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('products', ProductController::class);
    Route::resource('currencies', CurrencyController::class);
    Route::post('currencies/{currency}/set-default', [CurrencyController::class, 'setDefault'])->name('currencies.set-default');

    // User management routes
    Route::resource('users', UserManagementController::class);

    Route::post('logout', [UserController::class, 'logout'])->name('logout');

    Route::get('profile', [UserManagementController::class, 'profile'])->name('profile');
    Route::get('profile/edit', [UserManagementController::class, 'editProfile'])->name('profile.edit');
    Route::put('profile', [UserManagementController::class, 'updateProfile'])->name('profile.update');

    // Role management routes
    Route::get('roles', [UserManagementController::class, 'roles'])->name('roles.index');
    Route::post('roles', [UserManagementController::class, 'storeRole'])->name('roles.store');
    Route::get('roles/{role}/edit', [UserManagementController::class, 'editRole'])->name('roles.edit');
    Route::put('roles/{role}', [UserManagementController::class, 'updateRole'])->name('roles.update');
    Route::delete('roles/{role}', [UserManagementController::class, 'destroyRole'])->name('roles.destroy');

    // Permission management routes
    Route::get('permissions', [UserManagementController::class, 'permissions'])->name('permissions.index');
    Route::post('permissions', [UserManagementController::class, 'storePermission'])->name('permissions.store');
    Route::delete('permissions/{permission}', [UserManagementController::class, 'destroyPermission'])->name('permissions.destroy');

    Route::get('/invoice-view', function () {
        return view('back.invoices.pdf');
    });

    Route::get('invoices/bulk', function () {
        return view('invoices.bulk_download');
    })->name('invoices.bulk.download');
    Route::post('/invoices/bulk-download', [InvoiceController::class, 'bulkDownload'])->name('invoices.bulk-download');

    Route::get('quotations/{quotation}/download', [QuotationController::class, 'download'])->name('quotations.download');
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
});
