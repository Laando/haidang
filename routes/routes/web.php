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
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
Route::get('auth/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('auth/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('index.html', [
    'uses' => 'HomeController@index',
]);
Route::get('usercart',[
    'uses'=>'HomeUserController@viewCart',
    'as'=>'usercart'
]);
Route::post('usercart','HomeUserController@viewCart');
Route::post('userhome/ordertour','HomeUserController@ordertour');
Route::get('clearDemo','HomeController@clearDemo');
Route::post('socialCounter','HomeController@socialCounter');
Route::group(['middleware' => 'admin'], function () {
    Route::get('staff/delOrder','StaffController@delOrderForm');
    Route::post('staff/forcedel','StaffController@forceDelOrder');
    Route::post('function/changePromotion','FunctionController@changePromotion');
    Route::post('function/changeEvent','FunctionController@changeEvent');
    Route::post('function/changePercent','FunctionController@changePercent');
    Route::get('flushcache','FunctionController@flushcache');
    Route::post('function/updateTourAds','FunctionController@updateTourAds');
});
Route::post('function/uploadimage','FunctionController@UploadImage');
Route::post('function/closeHomeModal','FunctionController@closeHomeModal');
Route::group(['middleware' => 'auth'], function () {
    Route::post('function/sendConfirmEmail','HomeUserController@sendConfirmEmail');
    Route::post('function/confirmEmail','HomeUserController@confirmEmail');
});

Route::get('staff/start-date/list','StaffController@taolichkhoihanh')->name('startDateList');
Route::get('staff/start-date/tour/{id}','StaffController@manageStartDate')->name('startDateManage');
Route::get('staff/start-date/edit/{id}','StaffController@editStartDate')->name('startdateEdit');
Route::post('staff/start-date/edit/{id}','StaffController@postEditStartDate')->name('postEditStartDate');
Route::get('staff/start-date/create/{id}','StaffController@createStartDate')->name('createStartDate');
Route::post('staff/start-date/create/{id}','StaffController@postCreateStartDate')->name('postCreateStartDate');
Route::get('staff/start-date/remove/{id}','StaffController@removeStartDate')->name('removeStartDate');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
///////////Tour noel , tour tet duong lich , am lich , tour bien dao 2016
Route::get('du-lich-gia-re.html','HomeController@showCheapTour');
Route::get('chum-tour-dao-2017.html','HomeController@showIslandTour');
Route::get('tour-noel-2017.html','HomeController@showHolidayPage');
Route::get('tour-tet-duong-lich-2017.html','HomeController@showHolidayPage');
Route::get('tour-tet-am-lich-2017.html','HomeController@showHolidayPage');
Route::get('tour-gio-vang.html','HomeController@tourGioVang');
//SelfDesignTour
Route::get('design-tour','EditTourController@index');
//Feed
Route::get('rss', 'HomeController@buildRss');
//Sitemap
Route::get('sitemap.xml', 'HomeController@buildSitemap');
//Home
Route::get('tro-giup/{slug}','HomeController@viewHelp')->name('help');
Route::get('/', [
    'uses' => 'HomeController@index',
    'as' => 'home'
]);
Route::get('/tour-dong-gia.html', [
    'uses' => 'HomeController@showTourdonggia',
]);
Route::get('du-thi-anh.html','HomeController@indexEventPost');
Route::get('bai-du-thi.html','HomeController@listEventPost');
Route::get('the-le-du-thi.html','HomeController@ruleEventPost');
Route::get('eventblog/{slug}','HomeController@detailEventPost');
Route::get('eventblog','HomeController@applyEventPost');
Route::get('bai-du-thi.html','HomeController@listEventPost');
Route::post('eventblog/create','HomeUserController@createEventBlog');
Route::post('eventblog/edit','HomeUserController@editEventBlog');
Route::post('cart','HomeUserController@viewCart');

Route::post('updateCart','HomeUserController@updateCart');
Route::post('submitCart','HomeUserController@submitCart');
Route::post('function/getLoadAjaxTour','HomeController@getLoadAjaxTour');
Route::post('function/countLoadAjaxTour','HomeController@countLoadAjaxTour');
Route::post('function/getLoadAjaxOrder','HomeController@getLoadAjaxOrder');
Route::post('function/getLoadAjaxCheapTour','HomeController@getLoadAjaxCheapTour');
Route::post('function/loadAjaxDest','HomeController@loadAjaxDest');
Route::post('function/loadAjaxHotelDest','HomeController@loadAjaxHotelDest');
Route::post('function/loadReview','HomeController@loadReview');
Route::post('function/addWishlist','HomeController@addWishlist');
Route::post('showWishList','HomeController@showWishList');
Route::get('function/deleteWishlist','HomeController@deleteWishlist');
Route::get('search',[
    'uses'=>'HomeController@getSearch',
    'as'=>'search'
]);
Route::post('search',[
    'uses'=>'HomeController@getSearchText',
    'as'=>'searchpost'
]);
Route::get('resetpassword','HomeController@getEmailForm');
/*Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);*/
Route::get('noregister','HomeController@noregister');
//User homepage
Route::post('userhome/ConfirmGift', 'HomeUserController@ConfirmGift');
Route::get('userhome/gift', 'HomeUserController@gift');
Route::get('userhome/CheckPoint', 'HomeUserController@CheckPoint');
Route::get('userhome/{page}', 'HomeUserController@index');

Route::get('userhome/changeaddress','HomeUserController@changeaddress');
Route::post('userhome/updateaddress', 'HomeUserController@updateaddress');

Route::get('userhome/changepassword','HomeUserController@changepassword');
Route::post('userhome/updatepassword', 'HomeUserController@updatepassword');

Route::get('userhome/orderhistory','HomeUserController@orderhistory');
Route::post('userhome/update','HomeUserController@updateUser');
Route::post('userhome/updateInfo','HomeUserController@updateInfo');
Route::post('function/delCart','FunctionController@delCart');
//Admin
Route::get('staff/doFinished','StaffController@doFinished');
Route::get('language', 'HomeController@language');
Route::put('user/AdminChangePasswordUser/{user}',[
    'uses' => 'UserController@AdminChangePasswordUser' ,
    'middleware' => 'admin'
]);
Route::get('tin-tuc/diem-den/{slug}', [
    'uses' => 'HomeController@showBlogHomeByDestionationPoint',
]);
Route::get('tin-tuc', [
    'uses' => 'HomeController@showBlogHomeAll',
    'as' => 'tin-tuc'
]);
Route::get('thue-xe', [
    'uses' => 'HomeController@showCarHome',
    'as' => 'thue-xe-home'
]);
Route::get('bang-gia/{type}', [
    'uses' => 'HomeController@showPriceSheet',
    'as' => 'bang-gia-phan-loai'
]);
Route::get('bang-gia', [
    'uses' => 'HomeController@showPriceSheet',
    'as' => 'bang-gia'
]);
Route::get('tin-tuc/{slug}', [
    'uses' => 'HomeController@showBlogHome',
])->name('news');
Route::get('admin', [
    'uses' => 'AdminController@admin',
    'as' => 'admin',
    'middleware' => 'admin'
]);
Route::get('thue-xe/{slug}','HomeController@showCar');
//Staff homepage
/****************/
/*  Phòng đoàn   */
/****************/
Route::get('phong-doan','PhongDoanController@index');
Route::post('phong-doan','PhongDoanController@index');
Route::get('phong-doan/thong-ke','PhongDoanController@drawChart');
Route::get('phong-doan/edit/idself_tour={id}/isUpdated={isUpdated}', 'PhongDoanController@editSelfTour');
Route::post('phong-doan/update/idself_tour={id}', 'PhongDoanController@updateSelf');
Route::get('phong-doan/delete/id={id}', 'PhongDoanController@delete');

/********************/
/*   Self-Tour      */
/********************/
Route::post('self-tour','SelfTourController@CreateTour');

Route::get('typevehicle','TypeVehicleController@GetVehicle');
Route::get('success-booking','SelfTourController@CreateTour');
//Route::post('staff/find','StaffController@index');
Route::post('staff/getSeat','StaffController@getSeat');
Route::post('function/createOrder','StaffController@createOrder');
Route::get('staff','StaffController@index');
Route::post('staff','StaffController@index');
Route::get('staff/tour','StaffController@tour');
Route::get('staff/quanlytour','TourController@quanlytour')->name('tourmanage');
Route::get('staff/alltour','TourController@alltour');
Route::get('staff/order-stat', 'StaffController@orderStat')->name('orderStat');
Route::get('staff/order','StaffController@order')->name('orderList');
Route::get('staff/givenorder','StaffController@givenOrder');
Route::get('staff/giveorder/{give}','StaffController@givenOrder');
Route::get('staff/gift','StaffController@gift')->name('giftList');
Route::get('staff/givengift','StaffController@givenGift');
Route::get('staff/givegift/{give}','StaffController@givenGift');
Route::get('staff/customer','StaffController@customer')->name('customer');
Route::get('staff/startdate','StaffController@startdate');
Route::get('staff/process-order','StaffController@processOrder')->name('processOrder');
Route::get('staff/process-gift','StaffController@processGift')->name('processGift');
Route::get('staff/process-order/ajax','StaffController@ajaxProcessOrder');
Route::get('staff/order/ajax-tour', 'StaffController@ajaxTourData');
Route::get('staff/ajax-email', 'StaffController@ajaxUserData');
Route::get('staff/cancel/order/{id}', 'StaffController@cancelOrder')->name('cancelOrder');
Route::get('staff/cancel/gift/{id}', 'StaffController@cancelGift')->name('cancelGift');
Route::post('staff/process-order/{id}','StaffController@editProcessOrder')->name('editProcessOrder');
Route::post('staff/process-gift/{id}','StaffController@editProcessGift')->name('editProcessGift');
Route::post('staff/process-order','StaffController@createProcessOrder')->name('createProcessOrder');
Route::post('staff/startdate/isEnd','StaffController@endStartdate');
Route::post('function/getTourByDestinationPoint','FunctionController@getTourByDestinationPoint');
Route::post('staff/startdate/create','StaffController@startdateCreate');
Route::post('staff/startdate/edit', [
    'uses' => 'StaffController@startdateEdit',
    'as' => 'startdate.update'
]);

Route::post('staff/start-date/save/idTour={id}', 'StaffController@saveTourStartDate');

Route::post('staff/updateNote','StaffController@updateNote');
Route::post('function/getAdding','StaffController@getAdding');
Route::post('function/showCalculate','StaffController@showCalculate');
Route::post('function/showAdding','StaffController@showAdding');
Route::post('function/changeTransportType','StaffController@changeTransportType');
Route::post('function/showStartdate','FunctionController@showStartdate');
Route::post('function/delAdding','FunctionController@delAdding');
Route::post('function/getStartdate','FunctionController@getStartdate');
Route::post('staff/createUser','StaffController@createUser');
Route::post('staff/checkUser','StaffController@checkUser');
Route::post('staff/getTransportSeat','StaffController@getTransportSeat');
Route::post('staff/setSeat','StaffController@setSeat');
Route::get('staff/seat','StaffController@showSeat')->name('showCarList');
Route::post('staff/getTransportList','StaffController@getTransportList');
Route::post('staff/getSeatList','StaffController@getSeatList');
Route::post('staff/updateSeatInfor','StaffController@updateSeatInfor');
Route::post('staff/swapSeat','StaffController@swapSeat');
Route::post('staff/giftList','StaffController@giftList');
Route::post('staff/giftHistory','StaffController@giftHistory');
Route::post('staff/customerOrder','StaffController@customerOrder');
Route::post('staff/updateGift','StaffController@updateGift');
Route::post('staff/printTransportList','StaffController@printTransportList');
Route::get('staff/printCustomerList','StaffController@printCustomerList');
Route::get('staff/hotel','StaffController@showBookHotel');
Route::get('staff/{id}/hotel','StaffController@showBookDetail');
Route::get('staff/correctPoint','StaffController@correctPoint');
Route::get('staff/consult', 'StaffController@indexConsult')->name('consultStaff');
//Staff
Route::get('staff','StaffController@index');
Route::post('staff/getSeat','StaffController@getSeat');
Route::get('staff/neworder','StaffController@newOrder');
Route::post('staff','StaffController@index');
Route::get('staff/tour','StaffController@tour');
Route::get('staff/giveorder/{give}','StaffController@givenOrder');
Route::post('staff/createUser','StaffController@createUser');
Route::post('staff/checkUser','StaffController@checkUser');
Route::post('staff/showAdding','StaffController@showAdding');
Route::post('staff/createOrder','StaffController@createOrder');
Route::get('staff/editorder/{id}','StaffController@editOrder');
Route::get('home/GetAddings','HomeController@GetAddings');
Route::get('home/GetStartdate','HomeController@GetStartdate');
//Agent
Route::get('agent','AgentController@index');
Route::post('agent/getSeat','AgentController@getSeat');
Route::get('agent/neworder','AgentController@newOrder');
Route::post('agent','AgentController@index');
Route::get('agent/tour','AgentController@tour');
Route::get('agent/giveorder/{give}','AgentController@givenOrder');
Route::post('agent/createUser','AgentController@createUser');
Route::post('agent/checkUser','AgentController@checkUser');
Route::post('agent/showAdding','AgentController@showAdding');
Route::post('agent/createOrder','AgentController@createOrder');
Route::get('agent/editorder/{id}','AgentController@editOrder');
//User
Route::get('user/sort/{role}', 'UserController@indexSort');

Route::get('user/roles', 'UserController@getRoles');
Route::post('user/roles', 'UserController@postRoles');

Route::put('userseen/{id}', 'UserController@updateSeen');
Route::post('function/ratingTour','HomeController@ratingTour');

Route::resource('user', 'UserController');
Route::resource('miscalculate', 'MiscalculateController');
//Region
Route::get('regions','RegionController@edit');
Route::post('regions','RegionController@update');

//SourcePoint
Route::resource('sourcepoint','SourcePointController');
Route::get('sourcepoint/sort/{region}', 'SourcePointController@indexSort');
//DestinationPoint
Route::resource('destinationpoint','DestinationPointController');
Route::get('destinationpoint/sort/{region}', 'DestinationPointController@indexSort');
//SightPoint
Route::resource('sightpoint','SightPointController');
Route::get('sightpoint/sort/{destinationpoint}', 'SightPointController@indexSort');
//Review
Route::resource('review','ReviewController');
//Banner
Route::resource('banner','BannerController');
Route::get('banner/sort/{banner}', 'BannerController@indexSort');
//Config
Route::resource('config','ConfigController');
Route::get('config/sort/{banner}', 'ConfigController@indexSort');
//SubjectTour
Route::resource('subjecttour','SubjectTourController');
//Gift
Route::resource('gift','GiftController');
//Car
Route::resource('multiroute','MultiRouteController');
//Car
Route::resource('edittransport','EditTransportController');
//Car
Route::resource('meal','MealController');
//Car
Route::resource('car','CarController');
//Tour
Route::resource('tour','TourController');
//Blog
Route::resource('blog','BlogController');
//SubjectBlog
Route::resource('subjectblog','SubjectBlogController');
//AddingCate
Route::resource('addingcate','AddingCateController');
Route::resource('promocode','PromoCodeController');
//Hotel
Route::resource('hotel','HotelController');
//Consult
Route::resource('consult','ConsultController');
//Ajax Image
Route::post('sourcepoint/{id}/del-img','SourcePointController@delImage');
Route::post('destinationpoint/{id}/del-img','DestinationPointController@delImage');
Route::post('sightpoint/{id}/del-img','SightPointController@delImage');
Route::post('tour/{id}/del-img','TourController@delImage');
Route::post('blog/{id}/del-img','BlogController@delImage');
Route::post('subjecttour/{id}/del-img','SubjectTourController@delImage');
Route::post('gift/{id}/del-img','GiftController@delImage');
Route::post('car/{id}/del-img','CarController@delImage');
Route::post('hotel/{id}/del-img','HotelController@delImage');
Route::post('hotel/{id}/del-hotel-image','HotelController@delHotelImage');
//Function
Route::post('function/check','FunctionController@checkTitle');
Route::post('function/showSightPoint','FunctionController@showSightPoint');
Route::post('function/delOldStartDate','FunctionController@delOldStartDate');
Route::get('function/fixslug','FunctionController@fixslug');
Route::get('function/blogsearch','HomeController@blogSearch');
Route::post('function/blogsearch','HomeController@blogSearch');
//Ajax SightPoint
Route::post('tour/get-sightpoint-by-destinationpoint','TourController@getSightPointByDestinationPoint');
Route::post('tour/{id}/get-sightpoint-by-destinationpoint','TourController@getSightPointByDestinationPoint');

//login social
Route::get('oauth/{provider}', 'Auth\AuthController@loginfacebook');

////////////////admin function
Route::post('function/addHotelType','FunctionController@addHotelType');
Route::post('function/delHotelType','FunctionController@delHotelType');
Route::post('function/editHotelType','FunctionController@editHotelType');
Route::post('function/addHotelCharacter','FunctionController@addHotelCharacter');
Route::post('function/editHotelCharacter','FunctionController@editHotelCharacter');
Route::post('function/delHotelCharacter','FunctionController@delHotelCharacter');
Route::post('function/delHotelRoom','FunctionController@delHotelRoom');
Route::get('function/searchhotel','HomeController@searchHotel');
/////////////////////// khách sạn
Route::post('function/bookHotel','HomeController@bookHotel');
Route::get('khach-san', [
    'uses' => 'HomeController@showHotelHome',
    'as' => 'khach-san'
]);
Route::get('khach-san-{slug}', [
    'uses' => 'HomeController@showHotelByDestinationPoint',
    'as' => 'khach-san-diem-den'
]);
Route::get('khach-san/{slug}', [
    'uses' => 'HomeController@showHotelDetail',
    'as' => 'khach-san-detail'
]);
//Show user
Route::get('tour-du-lich', [
    'uses' => 'HomeController@showAllTour',
    'as' => 'tour-du-lich'
]);
Route::get('tour-trong-nuoc', [
    'uses' => 'HomeController@showDomesticTour',
    'as' => 'tour-trong-nuoc'
]);
Route::get('tour-nuoc-ngoai', [
    'uses' => 'HomeController@showOutboundTour',
    'as' => 'tour-nuoc-ngoai'
]);
Route::get('tour-doan', [
    'uses' => 'HomeController@showGroupTour',
    'as' => 'tour-doan'
]);
Route::get('member-gift', [
    'uses' => 'HomeController@showGift',
    'as' => 'member-gift'
])->name('member-gift');
Route::post('giftReceive','HomeController@showGift');
Route::get('chu-de-tour/{slug}', [
    'uses' => 'HomeController@showTourBySubjectTour',
    'as' => 'chu-de-tour'
]);
Route::post('filter_tour' , 'HomeController@showTourBySubjectTour');
Route::get('diem-den/{slug}', [
    'uses' => 'HomeController@showTourByDestinationPoint',
    'as' => 'diem-den'
]);
Route::get('tour-khuyen-mai', [
    'uses' => 'HomeController@tourle',
    'as' => 'tour-khuyen-mai'
]);
Route::get('tour-sieu-khuyen-mai', [
    'uses' => 'HomeController@superpromotiontour',
    'as' => 'tour-sieu-khuyen-mai'
]);
Route::get('tour-30-thang-4', [
    'uses' => 'HomeController@tour30thang4',
    'as' => 'tour-30-thang-4'
]);


Route::get('staff/get-car', 'StaffController@getCarList');



Route::post('staff/UpdateStartDate', 'StaffController@UpdateStartDate');
Route::post('staff/DeleteStartDate', 'StaffController@DeleteStartDate');
Route::post('staff/GetStartDate', 'StaffController@GetStartDate');
Route::post('staff/GetMiscalculate', 'StaffController@GetMiscalculate');
Route::post('staff/SendMail', 'StaffController@SendMail');
Route::post('home/GetTourResult', 'HomeController@GetTourResult');
Route::post('home/BookingTour', 'HomeController@BookingTour');
Route::post('home/CheckPromotionCode', 'HomeController@CheckPromotionCode');
Route::post('home/ConfirmOrder', 'HomeController@ConfirmOrder');



Route::post('update/car-seat/{id}', 'StaffController@updateCarSeat')->name('updateCarSeat');
Route::get('car-list/excel/{id}/{car_index}', 'StaffController@exportExcelCarList')->name('exportCarExcel');
Route::get('book/tour', 'HomeController@getTourInfoByDate');
Route::get('book/star', 'HomeController@getStarInfoByDate');
Route::get('book/surcharge', 'HomeController@getSurchargeInfoByDate');
Route::get('staff/check-customer', 'StaffController@getCustomerCheckPage')->name('checkCustomer');
Route::post('consult/send', 'HomeController@sendConsult')->name('sendConsult');
Route::get('consult/get', 'ConsultController@get')->name('getConsult');
Route::post('consult/check/{id}', 'ConsultController@check')->name('consult.check');
Route::get('/cam-nang-du-lich', [
    'uses' => 'HomeController@showBlogGuide',
    'as' => 'cam-nang-du-lich'
])->defaults('category', 'cam-nang-du-lich');
Route::get('/teambuilding', [
    'uses' => 'HomeController@showBlogTB',
    'as' => 'cam-nang-du-lich'
])->defaults('category', 'cam-nang-du-lich');
Route::get('/clear-cache', 'HomeController@clearcache')->name('clear-cache');
Route::get('/page/{slug}', [
    'uses' => 'HomeController@showPage',
    'as' => 'page-detail'
]);
Route::get('/booking', [
    'uses' => 'HomeController@booking',
    'as' => 'booking-tour'
]);
Route::get('/{slug}', [
    'uses' => 'HomeController@showTourDetail',
    'as' => 'tour-detail'
]);
