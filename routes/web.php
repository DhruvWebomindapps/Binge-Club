<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Master\BouquetController;
use App\Http\Controllers\Master\CakeController;
use App\Http\Controllers\Master\DecorationController;
use App\Http\Controllers\Master\GiftController;
use App\Http\Controllers\Master\PackageController;
use App\Http\Controllers\Master\SnackController;
use App\Http\Controllers\Master\StateController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\BookingController as FrontendBookingController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Master\CityController;
use App\Http\Controllers\Master\LocationController;
use App\Http\Controllers\Master\OtherController;
use App\Http\Controllers\Master\ScreenController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\TimeSlotController;
use Google\Client;
use Google\Service\Calendar;
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
Route::get("/googleCalendar",[PageController::class,"index"])->name("googleCalendar");
Route::get('/', function () {
    return view('frontend.index');
})->name('home');
Route::view('about-us', 'frontend.about-us')->name('about-us');
Route::get('blogs', ([PageController::class, 'blogs']))->name('blogs');
Route::get('blog/{slug}', ([PageController::class, 'blogDetails']))->name('blog.details');
Route::view('faq', 'frontend.faq')->name('faq');
Route::view('terms', 'frontend.terms')->name('terms');
Route::view('privacy', 'frontend.privacy')->name('privacy');
Route::view('carrer', 'frontend.carrer')->name('carrer');
Route::view('contact', 'frontend.contact')->name('contact');
Route::post('enquiry', [SendMailController::class,'inquiry'])->name('enquiry');

// Frontend Booking Routes
Route::get('screen-list', ([PageController::class, 'screenList']))->name('screen.list');
Route::get('screen/{id}/details', ([PageController::class, 'screenDetails']))->name('screen.details');
Route::get('checkout', ([PageController::class, 'checkout']))->name('checkout');
Route::get('/userDataGet', [PageController::class, 'userDataGet'])->name('getuserData');
Route::post('/user/booking', [FrontendBookingController::class, 'booking'])->name('user.booking');
Route::get('/booking/{id}/addons', [FrontendBookingController::class, 'selectAddons'])->name('booking.addons');
Route::post('/booking/{id}/addons', [FrontendBookingController::class, 'addonStore']);
Route::get('/bookedWithPayment/{id}', [FrontendBookingController::class, 'bookedWithPayment'])->name('bookedWithPayment');
Route::get('/congratulations', [PageController::class, 'thankyouPage']);
Route::get('/invoice_download/{id}', [FrontendBookingController::class, 'invoice_download']);


// payment getway route
Route::get('/initiate-payment/{id}', [PaymentController::class, 'initiatePayment'])->name('initiate-payment');
Route::get('/phonepe-response/{id}', [PaymentController::class, 'PhonePeResponse'])->name('phonepe-response');


Route::group(['prefix' => 'admin'], function () {
    Route::view('login', 'admin.auth.login')->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [PageController::class, 'userProfile'])->name('profile.edit');
        Route::post('/profile', [PageController::class, 'updateProfile']);
        // booking
        Route::resource('booking', BookingController::class);
        Route::get('/booking/delete/{id}', [BookingController::class, 'destroy']);
        // upcoming bookings
        Route::get('/upcoming/bookings', [BookingController::class, 'upcomingBooking'])->name('upcoming.booking');
        // today bookings
        Route::get('/today/bookings', [BookingController::class, 'todayBooking'])->name('today.booking');
        // cancelled  bookings
        Route::get('/cancelled/bookings', [BookingController::class, 'cancelledBooking'])->name('cancelled.booking');

        Route::get('/city/priority/change', [CityController::class, 'updatePriority'])->name('update.city.priority');
        Route::get('/location/priority/change', [LocationController::class, 'updatePriority'])->name('update.location.priority');
        Route::get('/screen/priority/change', [ScreenController::class, 'updatePriority'])->name('update.screen.priority');
        Route::get('/cake/priority/change', [CakeController::class, 'updatePriority'])->name('update.cake.priority');
        Route::get('/cake/price/change', [CakeController::class, 'updatePrice'])->name('update.cake.price');
        Route::get('/gift/priority/change', [GiftController::class, 'updatePriority'])->name('update.gift.priority');
        Route::get('/gift/price/change', [GiftController::class, 'updatePrice'])->name('update.gift.price');
        Route::get('/decoration/priority/change', [DecorationController::class, 'updatePriority'])->name('update.decoration.priority');
        Route::get('/decoration/price/change', [DecorationController::class, 'updatePrice'])->name('update.decoration.price');
        Route::get('/package/priority/change', [PackageController::class, 'updatePriority'])->name('update.package.priority');
        Route::get('/package/price/change', [PackageController::class, 'updatePrice'])->name('update.package.price');
        Route::get('/snacks/priority/change', [SnackController::class, 'updatePriority'])->name('update.snacks.priority');
        Route::get('/snacks/price/change', [SnackController::class, 'updatePrice'])->name('update.snacks.price');
        Route::get('/bouquet/priority/change', [BouquetController::class, 'updatePriority'])->name('update.bouquet.priority');
        Route::get('/bouquet/price/change', [BouquetController::class, 'updatePrice'])->name('update.bouquet.price');
        Route::get('/other/priority/change', [OtherController::class, 'updatePriority'])->name('update.other.priority');
        Route::get('/other/price/change', [OtherController::class, 'updatePrice'])->name('update.other.price');

        // customers
        Route::get('customers', [PageController::class, 'allCustomers'])->name('customers');

        // blogs
        Route::get('blogs', [BlogController::class, 'index'])->name('allblogs');
        Route::get('blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('blog/create', [BlogController::class, 'store']);
        Route::get('blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::post('blog/{id}/edit', [BlogController::class, 'update']);
        Route::get('blog/{id}/delete', [BlogController::class, 'destroy'])->name('blog.delete');
    });
    Route::group(['prefix' => 'master', 'middleware' => 'auth'], function () {
        // state
        Route::resource('/state', StateController::class);
        Route::get('/states/status/{id}', [StateController::class, 'changeStatus']);

        // city
        Route::resource('/city', CityController::class);
        Route::get('/getCity', [CityController::class, 'getCity']);
        Route::get('/city/status/{id}', [CityController::class, 'changeStatus']);

        // location
        Route::resource('/location', LocationController::class);
        Route::get('/location/status/{id}', [LocationController::class, 'changeStatus']);
        Route::get('/getLocation', [LocationController::class, 'getLocation']);

        // screen
        Route::resource('/screen', ScreenController::class);
        Route::get('/screen/status/{id}', [ScreenController::class, 'changeStatus']);
        Route::get('/screen_img/delete/{id}', [ScreenController::class, 'deleteMultiScreenImg']);
        Route::get('/add-more-features', [ScreenController::class, 'addMoreFeaturesField']);
        Route::post('/screen/more-feature', [ScreenController::class, 'addMoreFeature'])->name('screen.more-feature');
        Route::get('/remove-feature/{id}', [ScreenController::class, 'removefeature'])->name('remove.feature');
        Route::get('/getScreen', [ScreenController::class, 'getScreen']);

        // Cake
        Route::resource('cake', CakeController::class);
        Route::get('cake/changeStatus/{id}', [CakeController::class, 'changeStatus']);
        Route::get('cake/delete/{id}', [CakeController::class, 'destroy']);

        // gift
        Route::resource('gift', GiftController::class);
        Route::get('gift/changeStatus/{id}', [GiftController::class, 'changeStatus']);
        Route::get('gift/delete/{id}', [GiftController::class, 'destroy']);

        // snacks
        Route::resource('snacks', SnackController::class);
        Route::get('snacks/changeStatus/{id}', [SnackController::class, 'changeStatus']);
        Route::get('snacks/delete/{id}', [SnackController::class, 'destroy']);

        // Bouquet
        Route::resource('bouquet', BouquetController::class);
        Route::get('bouquet/changeStatus/{id}', [BouquetController::class, 'changeStatus']);
        Route::get('bouquet/delete/{id}', [BouquetController::class, 'destroy']);

        // decorations
        Route::resource('decoration', DecorationController::class);
        Route::get('decoration/changeStatus/{id}', [DecorationController::class, 'changeStatus']);
        Route::get('decoration/delete/{id}', [DecorationController::class, 'destroy']);

        // others
        Route::resource('other', OtherController::class);
        Route::get('other/changeStatus/{id}', [OtherController::class, 'changeStatus']);
        Route::get('other/delete/{id}', [OtherController::class, 'destroy']);

        // packages
        Route::resource('package', PackageController::class);
        Route::get('package/delete/{id}', [PackageController::class, 'destroy']);
        Route::get('/package/packImg/delete/{id}', [PackageController::class, 'packgeImgDelete']);
        Route::get('/package/status/{id}', [PackageController::class, 'changeStatus']);
    });
});
Route::get('/getTimeSlots', [TimeSlotController::class, 'getSlots']);
require __DIR__ . '/auth.php';
