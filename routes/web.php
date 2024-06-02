<?php

use App\Livewire\CartRender;
use App\Livewire\FreeRender;
use App\Livewire\ShopRender;
use App\Livewire\ShowRender;
use App\Livewire\PackageShow;
use App\Livewire\EnviosRender;

use App\Livewire\PackageRender;
use App\Livewire\Admin\ShowUser;
use App\Livewire\MembershipShow;
use App\Livewire\AccountProducts;
use App\Livewire\AccountShowOrder;
use App\Livewire\MembershipRender;
use Illuminate\Support\Facades\Auth;
use App\Livewire\AccountShowPackages;

use App\Livewire\Admin\IndexComments;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IpController;
use App\Livewire\AccountShowMembership;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SalesControler;
use App\Http\Controllers\GradeController;

use App\Http\Controllers\GrupoController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WebhooksController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\WebhooksControllerArnold;

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








//Route::get('/demo', [HomeController::class, 'index'])->name('home1'); //Listo


Route::get('/', [HomeController::class, 'index'])->name('home'); //Listo
Route::get('/banned', [HomeController::class, 'banned'])->name('banned');






//auth
Route::group(['middleware' => ['auth']], function () {
  Route::get('profile', [HomeController::class, 'profile'])->name('profile.edit');
  Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::put('profile/password', [ProfileController::class, 'password'])->name('profile.password');
});




Route::group(['middleware' => ['auth']], function () {


  Route::middleware(['auth.banned', 'ip.banned'])->group(function () {
    Route::get('customer/orders/{id}', AccountShowOrder::class)->name('order.show');
    Route::group(['middleware' => ['auth', 'verified']], function () {
      Route::get('customer/orders', [MainController::class, 'customerOrders'])->name('customer.orders');
      Route::get('customer/products', AccountProducts::class)->name('customer.products');
      Route::get('customer/packages', [MainController::class, 'customerPackages'])->name('customer.packages');
      Route::get('customer/packages/{id}', AccountShowPackages::class)->name('customer.packages-show');
      Route::get('customer/memberships', [MainController::class, 'customerMemberships'])->name('customer.memberships');
      Route::get('customer/memberships/{id}', AccountShowMembership::class)->name('customer.membership-show');
      Route::resource('customer/grupos', GrupoController::class);
      Route::resource('customer/estudiantes', StudentController::class);
      Route::get('customer/grupos/add-student/{id}', [MainController::class, 'addStudent'])->name('add-student'); //listo
      Route::get('customer/group-report/{id}', [MainController::class, 'groupReport'])->name('group-report'); //listo
      Route::get('customer/report/pdf/{id}', [MainController::class, 'groupReportPDF'])->name('group-report-pdf'); //listo
      Route::post('customer/reports/pdf/{id}', [MainController::class, 'groupReportsPDF'])->name('group-reports-pdf'); //listo
    });
  });
});


//admin
Route::group(['middleware' => ['role:admin']], function () {
  Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
  Route::resource('dashboard/products', ProductsController::class)->except('delete');
  Route::resource('dashboard/memberships', MembershipController::class)->except(['delete']);
  Route::resource('dashboard/category', CategoryController::class)->except('show');
  Route::resource('dashboard/package', PackageController::class)->except(['show', 'delete']);
  Route::resource('dashboard/degrees', GradeController::class)->except('show');
  Route::resource('dashboard/users', UsersController::class)->only(['index', 'update', 'edit']);
  Route::get('dashboard/comments', IndexComments::class)->name('comments.index');
  Route::resource('dashboard/sales', SalesControler::class)->except('update', 'delete');
  Route::resource('dashboard/ips', IpController::class)->only(['index']);
  Route::post('dashboard/sales/create/{user}', [MainController::class, 'createSales'])->name('orderp.create');
  Route::get('/verifiedUsers', [HomeController::class, 'verifiedUsers'])->name('verifiedUsers');

  Route::get('dashboard/users/{id}', ShowUser::class)->name('users.show');
});




//guest
Route::get('tienda', ShopRender::class)->name('shop.index'); //Listo
Route::get('tienda/productos/{id}', ShowRender::class)->name('shop.show');
Route::get('membresia-vip', MembershipRender::class)->name('membership'); //Listo
Route::get('tienda/paquetes', PackageRender::class)->name('paquete');
Route::get('membresia-vip/{id}', MembershipShow::class, '__invoke')->name('membership.show');
Route::get('tienda/paquetes/{id}', PackageShow::class, '__invoke')->name('paquete.show');
Route::get('tienda/gratuitos', FreeRender::class)->name('free'); //Listo
Route::get('cart', CartRender::class)->name('cart.index');
Route::get('search/products', [MainController::class, 'search'])->name('search.products'); //listo




//informacion
Route::get('contact', [MainController::class, 'contact'])->name('information.contact');
Route::post('contact', [MainController::class, 'storeContact'])->name('contact');
Route::get('frequent-questions', [MainController::class, 'questions'])->name('information.questions');
Route::get('términos-y-condiciones', [MainController::class, 'terminos'])->name('information.terminos');
Route::get('aviso-de-privacidad', [MainController::class, 'aviso'])->name('information.aviso');


Route::get('thanks_you', [MainController::class, 'thanks_you'])->name('shop.thanks');
Route::POST('thanks_you1', [MainController::class, 'thanks_you1'])->name('shop.thanks1');
Route::POST('createOrder', [MainController::class, 'createOrder'])->name('shop.createOrder');



//rutas de apoyo  

Route::group(['middleware' => ['role:admin']], function () {

  Route::get('dashboard/routes', [HomeController::class, 'routes'])->name('support.routes');
  Route::get('/storage-personal', [HomeController::class, 'storagePersonal'])->name('storage.personal');
  Route::get('/storage-link', [HomeController::class, 'storageMain'])->name('storage.link');
  Route::get('/clear-cache', [HomeController::class, 'clearCache'])->name('clear-cache');
  Route::get('/view-clear', [HomeController::class, 'viewCler'])->name('view-clear');




  //Clear route cache:
  Route::get('/route-cache', function () {
    Artisan::call('route:cache');
    return 'Routes cache has been cleared';
  });

  //Clear config cache:
  Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cache has been cleared';
  });
});


Route::post('webhooks', WebhooksController::class);
Route::post('webhooks-arnold', WebhooksControllerArnold::class)->name('webhooks-arnold');
