<?php

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

use App\Category;
use App\Product;
use App\Store;
use App\User;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/product/{slug}', 'HomeController@single')->name('product.single');
Route::get('/category/{slug}','CategoryController@index')->name('category.single');
Route::get('/store/{slug}','StoreController@index')->name('store.single');
Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/', 'CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');
    Route::get('/remove/{slug}', 'CartController@remove')->name('remove');
    Route::get('cancel', 'CartController@cancel')->name('cancel');
});

Route::prefix('checkout')->name('checkout.')->group(function(){
    Route::get('/', 'CheckoutController@index')->name('index');
    Route::post('/proccess','CheckoutController@proccess')->name('proccess');
    Route::get('/thanks','CheckoutController@thanks')->name('thanks');
});

Route::get('my-orders', 'UserOrderController@index')->name('user.orders')->middleware('auth');

Route::group(['middleware' => ['auth', 'access.control.store.admin']], function(){



    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function(){

        Route::get('notifications', 'NotificationController@notifications')->name('notification.index');
        Route::get('notifications/read-all', 'NotificationController@readAll')->name('notification.read.all');
        Route::get('notifications/read/{notification}', 'NotificationController@read')->name('notification.read');

//    Route::prefix('stores')->name('stores.')->group(function(){
//        Route::get('/', 'StoreController@index')->name('index');
//        Route::get('/create', 'StoreController@create')->name('create');
//        Route::post('/', 'StoreController@store')->name('store');
//        Route::get('/{store}/edit', 'StoreController@edit')->name('edit');
//        Route::post('/update/{store}', 'StoreController@update')->name('update');
//        Route::get('/destroy/{store}', 'StoreController@destroy')->name('destroy');
//    });
        Route::resource('stores','StoreController');
        Route::resource('products','ProductController');
        Route::resource('categories','CategoryController');

        Route::post('photos/remove','ProductPhotoController@removePhoto')->name('photo.remove');

        Route::get('orders/my', 'OrdersController@index')->name('orders.my');
    });
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');//->middleware('auth');

Route::get('/model', function(){
//    $products = Product::all();

//    $user = new User();
//    $user = User::find(41);
//    $user->name = 'teste editado';
//    $user->email = 'teste@teste.com';
//    $user->password = bcrypt('12345678');
//
//    $user->save();

//    return User::all();
//    return  User::find(1);
//    return  User::where('name','Melvin Gislason')->get();
//    return User::paginate(10);

//    $user = User::create([
//        'name' => 'teste 2',
//        'email' => 'teste2@email',
//        'password' => bcrypt('12345678'),
//    ]);

//    $user = User::find(42);
//    $user->update([
//        'name' => 'teste atualizado',
//    ]);

//    $user = User::find(4);

//    return $user->store;

//    $loja = Store::find(1);

//    return $loja->products;
//    return User::all();

//    $categoria = Category::find(1);
//    return $categoria->products;
});


//Route::get('not', function(){
//    $user = \App\User::find(45);

//    $user->notify(new \App\Notifications\StoreReceiveNewOrder());

//    $notification = $user->unreadNotifications->first();

//    $notification->markAsRead();

//    return $user->unreadNotifications;

//    return $user->readNotifications;
//});
