<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\mailController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
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
Route::group(['prefix' => 'invoice'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/invoice-view', function () {
        return view('back.invoices.pdf');
    });

    Route::get('invoices/bulk', function () {
        return view('invoices.bulk_download');
    })->name('invoices.bulk.download');
    Route::post('/invoices/bulk-download', [InvoiceController::class, 'bulkDownload'])->name('invoices.bulk-download');

    // Client routes
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::resource('clients', ClientController::class)->except(['store']);

    // Resource Routes
    Route::resource('products', ProductController::class);
    Route::resource('quotations', QuotationController::class);
    Route::get('quotations/{quotation}/download', [QuotationController::class, 'download'])->name('quotations.download');
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
});
