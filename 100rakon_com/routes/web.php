<?php
Auth::routes(['verify' => true]);
// Route::get('/logout', 'HomeController@index')->name('home')->middleware('verified');
// Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/social/{provider}', [
    'as' => 'social.login',
    'uses' => 'Auth\SocialController@execute',
]);

//사용자 ============================================================================
// 일반 페이지
Route::get('/', function () {   return view('mall.home');   });
Route::get('exist-email-check', 'IntroductionController@existEmailCheck');     //이미 사용중인 이메일 여부 점검(회원가입용)
Route::get('intro', 'IntroductionController@intro');            //백락온 소개
Route::get('saranghae', 'IntroductionController@saranghae');            //사랑해 골드 소개
Route::get('terms-use', function () {   return view('mall.terms-use');   });       //이용약관
Route::get('terms-privacy', function () {   return view('mall.terms-privacy');   });       //개인정보 취급방침
Route::resource('/qna', 'QnaController');           //고객센터

// 제품페이지
Route::get('product', 'ProductController@index');
Route::get('product/{pdx}', 'ProductController@view')->name('product.show');

// 주문관련
Route::post('order', 'OrderController@order');
Route::post('order-save', 'OrderController@orderSave')->middleware('auth');
Route::get('order/basket', 'OrderController@basket')->middleware('auth');
Route::get('order/basket-direct', 'OrderController@basketDirect')->middleware('auth');
Route::post('order/basket-add', 'OrderController@basketAdd')->middleware('auth');
Route::post('order/basket-remove', 'OrderController@basketRemove')->middleware('auth');

// 정기배송
Route::get('subscrib', 'SubscribController@index');
Route::post('subscrib/order', 'SubscribController@order')->name('subscrib.order')->middleware('auth');
Route::post('subscrib/order-save', 'SubscribController@save')->name('subscrib.save')->middleware('auth');
Route::get('subscrib/{sgdx}', 'SubscribController@view')->name('subscrib.show');

// 토스관련
Route::get('toss/pay-toss-success', 'TossController@payTossSuccess')->middleware('auth');
Route::post('toss/pay-toss-fail', 'TossController@payTossFail');
Route::post('toss/pay-toss-virtual', 'TossController@payTossVirtual');
Route::post('toss/pay-toss-webhook', 'TossController@payTossWebHook');

// 나의 정보
Route::get('myorder', 'MyOrderController@index')->middleware('auth');
Route::get('myorder-subscrib', 'MyOrderController@subscribIndex')->middleware('auth');
Route::get('myorder-outstand', 'MyOrderController@outstandIndex');
Route::get('myorder-outstand-guest', 'MyOrderController@outstandGuest');
Route::get('myorder-outstand-guest-input', 'MyOrderController@outstandGuestInput');
Route::resource('/myaddress', 'MyAddressController')->middleware('auth');
Route::get('myinfo', 'MyInfoController@index')->middleware('auth');
Route::post('myinfo/edit', 'MyInfoController@edit')->middleware('auth');
Route::post('myinfo/secession', 'MyInfoController@secession')->middleware('auth');

// 특별상품
Route::get('outstand', 'OutstandController@index');
Route::get('outstand/{osdx}', 'OutstandController@view')->name('outstand.show');
Route::get('outstand/direct/{osdx}/{quantity}', 'OutstandController@direct');
Route::post('outstand/order', 'OutstandController@order')->name('outstand.order');
Route::post('outstand/order-save', 'OutstandController@save');
//관리자 ============================================================================
Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware('check.admin')->group(function () {
    Route::get('/home', 'AdminHomeController@index')->name('home');

    Route::resource('/users', 'AdminUserController')->parameters([
        'users' => 'udx'
    ])->except(['create', 'store']);

    Route::resource('/user-addresses', 'AdminUserAddressController')->parameters([
        'user-addresses' => 'uadx'
    ])->except(['index', 'show', 'create', 'store']);

    Route::resource('/user-baskets', 'AdminUserBasketController')->parameters([
        'user-baskets' => 'obdx'
    ])->except(['index', 'show', 'create', 'store']);

    Route::resource('/categories', 'AdminCategoryController')->parameters([
        'categories' => 'pcdx'
    ]);

    Route::resource('/products', 'AdminProductController')->parameters([
        'products' => 'pdx'
    ]);

    //특별상품
    Route::resource('/outstands', 'AdminOutstandController')->parameters([
        'outstands' => 'osdx'
    ]);

    Route::resource('/outstand-categories', 'AdminOutstandCategoryController')->parameters(['outstand-categories' => 'oscdx?']);

    Route::resource('/outstand-orders', 'AdminOutstandOrderController')->parameters(['outstand-orders' => 'osodx?']);

    Route::post('/outstands/remove/{fdx}', 'AdminOutstandController@removeImage')->name('outstands.removeimage');

    Route::resource('/outstand-orders', 'AdminOutstandOrderController')->parameters([
        'outstand-orders' => 'osodx'
    ])->except(['create', 'store']);

    Route::post('/orders/history-create', 'AdminOrderController@historyCreate');
    Route::resource('/orders', 'AdminOrderController')->parameters([
        'orders' => 'odx'
    ])->except(['create', 'store']);

    Route::resource('/orderitems', 'AdminOrderItemController')->parameters([
        'orderitems' => 'oidx'
    ])->except(['index', 'show', 'create', 'store']);

    Route::post('/products/remove/{fdx}', 'AdminProductController@removeImage')->name('products.removeimage');

    //정기배송
    Route::resource('/subscrib-categories', 'AdminSubscribGoodCategoryController')->parameters(['subscrib-categories' => 'sgcdx?']);
    Route::resource('/subscrib-goods', 'AdminSubscribGoodController')->parameters(['subscrib-goods' => 'sgdx?']);
    Route::post('/subscrib-goods/remove/{fdx}', 'AdminSubscribGoodController@removeImage')->name('subscrib-goods.removeimage');

    Route::post('/subscrib-orders/history-create', 'AdminSubscribOrderController@historyCreate');
    Route::resource('/subscrib-orders', 'AdminSubscribOrderController')->parameters([
        'subscrib-orders' => 'sodx'
    ])->except(['create', 'store']);

    Route::resource('/qnas', 'AdminQnaController')->parameters([
        'qnas' => 'idx'
    ])->except(['create', 'store']);
});
