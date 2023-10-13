<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StoreContoller;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SpecialController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\HoursLocationController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CategoryAjaxController;
use App\Http\Controllers\AdminConteroller;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\user\UserHomeController;
use App\Http\Controllers\user\UserStoreController;
use App\Http\Controllers\user\UserDiningController;
use App\Http\Controllers\user\UserMoviesController;
use App\Http\Controllers\user\UserEventsController;
use App\Http\Controllers\user\UserHLocationController;
use App\Http\Controllers\user\UserPhotoGalleryController;
use App\Http\Controllers\user\UserDataController;
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

Route::group(['domain' => '{signup}.simivalleylocal.com'], function () {
    Route::get('/', [UserDataController::class,'event_signup']);
    Route::post('/eventregister',[UserDataController::class,'event_register']);
});

Route::get('/',[UserHomeController::class,'index']);

Route::get('/usersignup', [UserDataController::class,'event_signup']);
Route::post('/eventregister',[UserDataController::class,'event_register']);
Route::get('/add_event_data',[UserDataController::class,'add_event_data']);
Route::post('/setsignupdata',[UserDataController::class,'setsignupdata']);

Route::get('user/sign-up',[UserDataController::class,'signup']);
Route::post('user/userRegister',[UserDataController::class,'user_signup']);
Route::get('user/sign-in',[UserDataController::class,'signin']);
Route::post('user/userLogin',[UserDataController::class,'user_signin']);
Route::get('user/logout',[UserDataController::class,'logout']);
Route::get('user/home',[UserHomeController::class,'index']);
Route::get('user/stores',[UserStoreController::class,'all_store']);
Route::get('user/Dining',[UserDiningController::class,'all_restaurant']);
Route::get('user/Movies',[UserMoviesController::class,'index']);
Route::get('user/Events',[UserEventsController::class,'all_events']);
Route::get('user/event-detail/{id}',[UserEventsController::class,'get_event_detail']);
Route::get('user/HLocation',[UserHLocationController::class,'index']);
Route::get('user/PhotoGallery',[UserPhotoGalleryController::class,'index']);
Route::get('user/EmpOpportunity',[UserDataController::class,'emp_opportunity']);
Route::get('user/GeneralComments',[UserDataController::class,'general_comments']);
Route::get('user/LeasingInfo',[UserDataController::class,'leasing_info']);
Route::post('user/searchMovie',[UserMoviesController::class,'movie_search']);
Route::get('user/get-category-wise/{id}',[UserStoreController::class,'category_wise_data']);
Route::get('user/get-category-name/{id}',[CategoryController::class,'get_category_name']);
Route::get('user/get-category-name-dinning/{id}',[CategoryController::class,'get_category_name_dynamic']);

Route::post('user/searchStore',[UserStoreController::class,'store_search']);
Route::post('user/searchEvent',[UserEventsController::class,'event_search']);
Route::get('user/get-category-wise-event/{id}',[UserEventsController::class,'category_wise_data']);
Route::get('user/get-category-wise-restaurant/{id}',[UserDiningController::class,'category_wise_data']);
Route::get('user/get-date-wise-event/{id}',[UserEventsController::class,'date_wise_data']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('pagenotfound', ['as' => 'notfound', 'uses' => 'HomeController@pagenotfound']);


Route::get('add_category_view',[CategoryController::class,'add_category_view'])->middleware('auth');
Route::post('add_category_data',[CategoryController::class,'add_category_data'])->name('add_category_data')->middleware('auth');
Route::get('list_category',[CategoryController::class,'list_category'])->name('list_category')->middleware('auth');
Route::get('delete_category/{id}',[CategoryController::class,'delete_category'])->middleware('auth');
Route::get('edit_category/{id}',[CategoryController::class,'edit_category'])->middleware('auth');
Route::put('edit_category_data',[CategoryController::class,'edit_category_data'])->name('edit_category_data')->middleware('auth');

Route::get('add_store_view',[StoreContoller::class,'add_store_view'])->middleware('auth');
Route::get('list_store',[StoreContoller::class,'list_store'])->name('list_store')->middleware('auth');
Route::post('add_store_data',[StoreContoller::class,'add_store_data'])->name('add_store_data')->middleware('auth');
Route::get('all_store',[StoreContoller::class,'all_store'])->middleware('auth');
Route::get('delete_store/{id}',[StoreContoller::class,'delete_store'])->middleware('auth');
Route::get('edit_store/{id}',[StoreContoller::class,'edit_store'])->middleware('auth');
Route::put('edit_store_data',[StoreContoller::class,'edit_store_data'])->name('edit_store_data')->middleware('auth');

Route::get('addMovie',[MovieController::class,'createMovie'])->middleware('auth');
Route::post('storeMovie',[MovieController::class,'storeMovie'])->middleware('auth');
Route::get('all_movie',[MovieController::class,'all_movie'])->middleware('auth');
Route::get('edit_movie/{id}',[MovieController::class,'edit_movie'])->middleware('auth');
Route::put('edit_movie_data',[MovieController::class,'edit_movie_data'])->name('edit_movie_data')->middleware('auth');
Route::get('delete_movie/{id}',[MovieController::class,'deleteMovie'])->middleware('auth');

Route::get('addSlider',[SliderController::class,'createSlider'])->middleware('auth');
Route::post('storeSlider',[SliderController::class,'storeSlider'])->middleware('auth');
Route::get('all_slider_item',[SliderController::class,'all_slider'])->middleware('auth');
Route::get('edit_slider/{id}',[SliderController::class,'edit_slider'])->middleware('auth');
Route::put('edit_slider_data',[SliderController::class,'edit_slider_data'])->name('edit_slider_data')->middleware('auth');
Route::get('delete_slider/{id}',[SliderController::class,'deleteSlider'])->middleware('auth');

Route::get('addPhoto',[PhotoController::class,'createPhoto'])->middleware('auth');
Route::post('storePhoto',[PhotoController::class,'storePhoto'])->middleware('auth');
Route::get('all_photo',[PhotoController::class,'all_photo'])->middleware('auth');
Route::get('edit_photo/{id}',[PhotoController::class,'edit_photo'])->middleware('auth');
Route::put('edit_photo_data',[PhotoController::class,'edit_photo_data'])->name('edit_photo_data')->middleware('auth');
Route::get('delete_photo/{id}',[PhotoController::class,'deletePhoto'])->middleware('auth');


Route::get('addPhotofolder',[PhotoController::class,'createPhotoFolder'])->middleware('auth');
Route::post('storePhotoFolder',[PhotoController::class,'storePhotoFolder'])->middleware('auth');
Route::get('edit_photo_folder/{id}',[PhotoController::class,'edit_photo_folder'])->middleware('auth');
Route::put('edit_photo_folder_data',[PhotoController::class,'edit_photo_folder_data'])->name('edit_photo_folder_data')->middleware('auth');
Route::get('delete_photo_folder/{id}',[PhotoController::class,'deletePhotoFolder'])->middleware('auth');

Route::get('addEvent',[EventController::class,'createEvent'])->middleware('auth');
Route::post('storeEvent',[EventController::class,'storeEvent'])->middleware('auth');
Route::get('all_event',[EventController::class,'all_event'])->middleware('auth');
Route::get('event_users',[EventController::class,'event_users'])->middleware('auth');
Route::get('edit_event/{id}',[EventController::class,'edit_event'])->middleware('auth');
Route::put('editEvent_data',[EventController::class,'edit_event_data'])->middleware('auth');

Route::get('delete_event/{id}',[EventController::class,'delete_event'])->middleware('auth');

Route::get('edit_event_new/{id}',[EventController::class,'edit_event_new'])->middleware('auth');
Route::put('editEvent_data_new',[EventController::class,'edit_event_data_new'])->middleware('auth');
Route::get('delete-image/{name}/{id}',[EventController::class,'delete_image'])->middleware('auth');

Route::get('manageRole',[RoleController::class,'all_role'])->middleware('auth');
Route::get('createRole',[RoleController::class,'createRole'])->middleware('auth');
Route::post('storeRole',[RoleController::class,'storeRole'])->middleware('auth');
Route::get('delete_role/{id}',[RoleController::class,'delete_role'])->middleware('auth');
Route::get('edit_role/{id}',[RoleController::class,'edit_role'])->middleware('auth');
Route::put('edit_role_data',[RoleController::class,'edit_role_data'])->middleware('auth');

Route::get('manageRestaurant',[RestaurantController::class, 'manageRestaurant'])->middleware('auth');
Route::get('createRestaurant',[RestaurantController::class, 'createRestaurant'])->middleware('auth');
Route::post('add_restaurant_data',[RestaurantController::class, 'storeRestaurant'])->middleware('auth');
Route::get('delete_restaurant/{id}',[RestaurantController::class, 'deleteRestaurant'])->middleware('auth');
Route::get('edit_restaurant/{id}',[RestaurantController::class,'edit_restaurant'])->middleware('auth');
Route::put('edit_restaurant_data',[RestaurantController::class,'edit_restaurant_data'])->middleware('auth');

Route::get('user-list',[UserDataController::class,'get_all_user'])->middleware('auth');
Route::get('edit_user/{id}',[UserDataController::class,'edit_user'])->middleware('auth');
Route::put('edit_user_data',[UserDataController::class,'edit_user_data'])->middleware('auth');
Route::get('delete_user/{id}',[UserDataController::class, 'deleteUser'])->middleware('auth');

Route::get('add_h-location',[HoursLocationController::class,'add_hlocation'])->middleware('auth');
Route::post('storeLocation',[HoursLocationController::class,'add_hlocation_data'])->middleware('auth');
Route::get('list_hlocation',[HoursLocationController::class,'all_hlocation'])->middleware('auth');

Route::get('add_footer',[FooterController::class,'add_footer'])->middleware('auth');
Route::post('storeFooter',[FooterController::class,'add_footer_data'])->middleware('auth');
Route::get('list_footer',[FooterController::class,'all_footer'])->middleware('auth');

Route::get('addSpecial',[SpecialController::class,'createSpecial'])->middleware('auth');
Route::post('storeSpecial',[SpecialController::class,'storeSpecial'])->middleware('auth');
Route::get('all_special',[SpecialController::class,'all_special'])->middleware('auth');
Route::get('edit_special/{id}',[SpecialController::class,'edit_special'])->middleware('auth');
Route::put('edit_special_data',[SpecialController::class,'edit_special_data'])->name('edit_special_data')->middleware('auth');
Route::get('delete_special/{id}',[SpecialController::class,'deleteSpecial'])->middleware('auth');

Route::get('addTenant',[TenantController::class,'createTenant'])->middleware('auth');
Route::post('storeTenant',[TenantController::class,'storeTenant'])->middleware('auth');
Route::get('all_tenant',[TenantController::class,'all_tenant'])->middleware('auth');
Route::get('edit_tenant/{id}',[TenantController::class,'edit_tenant'])->middleware('auth');
Route::put('edit_tenant_data',[TenantController::class,'edit_tenant_data'])->name('edit_tenant_data')->middleware('auth');
Route::get('delete_tenant/{id}',[TenantController::class,'deleteTenant'])->middleware('auth');

Route::get('logout',[AdminConteroller::class,'logout']);

Route::get('get_movie_file_data',[MovieController::class,'get_movie_file_data']);

$appRoutes = function() {
    Route::get('/testsignup/',function(){
        return view('welcome');
    });
};

Route::get('test',function(){
    return view('test');
});
