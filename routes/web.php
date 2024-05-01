<?php

use App\Models\Order;
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
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\WebhooksController;
use App\Http\Controllers\MembershipController;
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


Route::group(['middleware' => ['auth', 'verified']], function () {

  Route::get('customer/memberships', [MainController::class, 'customerMemberships'])->name('customer.memberships');
});


Route::group(['middleware' => ['auth']], function () {

  Route::middleware(['auth.banned', 'ip.banned'])->group(function () {
    Route::group(['middleware' => ['auth', 'verified']], function () {
      Route::get('customer/orders', [MainController::class, 'customerOrders'])->name('customer.orders');
      Route::get('customer/orders/{id}', AccountShowOrder::class)->name('order.show');
      Route::get('customer/products', AccountProducts::class)->name('customer.products');
      Route::get('customer/packages', [MainController::class, 'customerPackages'])->name('customer.packages');
      Route::get('customer/packages/{id}', AccountShowPackages::class)->name('customer.packages-show');

      Route::get('customer/memberships/{id}', AccountShowMembership::class)->name('customer.membership-show');
    });
  });
});


//admin
Route::group(['middleware' => ['role:admin']], function () {
  Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
  Route::resource('dashboard/products', ProductsController::class)->except('delete');
  Route::resource('dashboard/memberships', MembershipController::class)->except(['delete', 'show']);
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
  Route::get('/link', function () {
    $target = '/home3/materi65/shop2024/storage/app/public';
    $link =   '/home3/materi65/public_html/storage';
    symlink($target, $link);
    echo "Link done";
  });

  Route::get('/storage-link', function () {
    $target = storage_path('app/public');
    $link =   $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($target, $link);
    echo "storage link success";
  });

  Route::get('/foo', function () {
    Artisan::call('storage:link');
    echo "storage done";
  });


  // Clear application cache:
  Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
  });

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

  // Clear view cache:
  Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
  });

  // pruebas cURL MP:
  Route::get('/curl', function () {
    $ACCESS_TOKEN = "APP_USR-2311547743825741-013023-3721797a3fbdf97bf2d4ff3f58000481-269113557"; //aqui cargamos el token
    $curl = curl_init(); //iniciamos la funcion curl

    curl_setopt_array($curl, array(
      //ahora vamos a definir las opciones de conexion de curl
      CURLOPT_URL => "https://api.mercadopago.com/v1/payments/77035052505", //aqui iria el id de tu pago
      CURLOPT_CUSTOMREQUEST => "GET", // el metodo a usar, si mercadopago dice que es post, se cambia GET por POST.
      CURLOPT_RETURNTRANSFER => true, //esto es importante para que no imprima en pantalla y guarde el resultado en una variable
      CURLOPT_ENCODING => "",
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $ACCESS_TOKEN
      ),
    ));



    $response = curl_exec($curl); //ejecutar CURL
    $response = json_decode($response, true); //a la respuesta obtenida de CURL la guardamos en una variable con formato json.


    //$order = Order::findOrFail($response['external_reference']);
    return $response;
  });
});


Route::post('webhooks', WebhooksController::class);
Route::post('webhooks-arnold', WebhooksControllerArnold::class)->name('webhooks-arnold');
