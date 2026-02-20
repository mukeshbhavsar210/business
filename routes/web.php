<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\Sub2CategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

//Front pages routes
Route::controller(FrontController::class)->group(function() {
    Route::get('/', 'index')->name('front.home');
    Route::post('/add-to-wishlist', 'addToWishlist')->name('front.addToWishlist');
    Route::get('/page/{slug}', 'page')->name('front.page');
    Route::post('/send-contact-email', 'sendContactEmail')->name('front.sendContactEmail');
});

Route::controller(ShopController::class)->group(function() {
    Route::get('/shop/{categorySlug?}/','category')->name('front.category.shop');
    Route::get('/products/{subCategorySlug?}/{subSubCategory?}','index')->name('front.shop');
    Route::get('/product/{slug}','product')->name('front.product');
});

Route::controller(CartController::class)->group(function() {
    Route::get('/cart','cart')->name('front.cart');
    Route::post('/update-cart','updateCart')->name('front.updateCart');
    Route::post('/add-to-cart','addToCart')->name('front.addToCart');
    Route::post('/update-cart','updateCart')->name('front.updateCart');
    Route::post('/delete-item','deleteItem')->name('front.deleteItem.cart');
    Route::get('/checkout','checkout')->name('front.checkout');
    Route::post('/process-checkout','processCheckout')->name('front.processCheckout');
    Route::get('/thanks/{orderId}','thankyou')->name('front.checkout.thankyou');
    Route::post('/get-order-summary','getOrderSummary')->name('front.getOrderSummary');
    Route::post('/apply-discount','applyDiscount')->name('front.applyDiscount');
    Route::post('/remove-discount','removeCoupon')->name('front.removeCoupon');

    //Payment routes
    Route::post('checkout/razorpay', 'razorpayPayment')->name('checkout.razorpay');
    Route::get('checkout/payment-success','razorpaySuccess')->name('checkout.success');
    Route::get('checkout/payment-failed', 'razorpayFailed')->name('checkout.failed');    
});

//User realted
Route::group(['prefix' => 'account'], function(){
    Route::group(['middleware' => 'guest'], function(){
        Route::controller(AuthController::class)->group(function() {
            Route::get('/login','login')->name('account.login');
            Route::post('/login','authenticate')->name('account.authenticate');
            Route::get('/register','register')->name('account.register');
            Route::post('/process-register','processRegister')->name('account.processRegister');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::controller(AuthController::class)->group(function() {
            Route::get('/dashboard','dashboard')->name('account.dashboard');
            Route::get('/address','address')->name('account.address');
            Route::get('/cards','cards')->name('account.cards');
            Route::get('/profile','profile')->name('account.profile');
            Route::get('/profile/edit','profileEdit')->name('account.profile.edit');
            Route::post('/update-profile','updateProfile')->name('account.updateProfile');
            Route::post('/update-address','updateAddress')->name('account.updateAddress');
            Route::get('/password','changePasswordForm')->name('account.changePassword');
            Route::post('/change-password','changePassword')->name('account.processChangePassword');
            Route::get('/orders','orders')->name('account.orders');
            Route::get('/wishlist','wishlist')->name('account.wishlist');
            Route::post('/remove-product-from-wishlist','removeProductFromWishlist')->name('account.removeProductFromWishlist');
            Route::get('/item/details/{orderId}','orderDetail')->name('account.orderDetail');
            Route::get('/logout','logout')->name('account.logout');
        });
    });
});

//Admin related
Route::group(['prefix' => 'admin'], function(){
    Route::group(['middleware' => 'admin.guest'], function(){
        Route::controller(AdminLoginController::class)->group(function() {
            Route::get('/login', 'index')->name('admin.login');
            Route::post('/authenticate', 'authenticate')->name('admin.authenticate');
        });
    });

    Route::group(['middleware' => 'admin.auth'], function(){
        Route::controller(HomeController::class)->group(function() {
            Route::get('/dashboard', 'index')->name('admin.dashboard');
            Route::get('/logout', 'logout')->name('admin.logout');
        });

        //Category Routes
        Route::controller(CategoryController::class)->group(function() {
            Route::get('/category', 'index')->name('categories.index');
            Route::get('/category/create', 'create')->name('categories.create');
            Route::post('/category/cat', 'category_store')->name('category.store');
            Route::get('/category/{category}/edit', 'category_edit')->name('category.edit');
            Route::put('/category/{category}', 'category_update')->name('categories.update');
            Route::delete('/category/cat/{category}', 'category_destroy')->name('category.delete');
            
            //sub category edit and update
            Route::post('/category/sub-category/', 'sub_category_store')->name('sub_category.store');
            Route::get('/category/sub/{subCategory}/edit', 'sub_category_edit')->name('sub_category.edit');
            Route::put('/category/sub/{subCategory}', 'sub_category_update')->name('sub_category.update');
            Route::delete('/category/sub/{subCategory}', 'sub_category_destroy')->name('sub_category.delete');
            
            //sub2 category edit and update
            Route::post('/category/sub2-category/', 'sub2_category_store')->name('sub2_category.store');
            Route::get('/category/sub2/{subCategory}/edit', 'sub2_category_edit')->name('sub2_category.edit');
            Route::put('/category/sub2/{subCategory}', 'sub2_category_update')->name('sub2_category.update');
            Route::delete('/category/sub2/{sub2Category}', 'sub2_category_destroy')->name('sub2_category.delete');

            Route::get('/get-subcategories/{id}', 'getSubCategories')->name('get.subcategories');
        });       

        //Brands
        Route::controller(BrandController::class)->group(function() {
            Route::get('/brands', 'index')->name('brands.index');            
            Route::post('/brands', 'store')->name('brands.store');            
            Route::delete('/brands/{brand}', 'destroy')->name('brands.delete');
        });

        //Product Route
        Route::controller(ProductController::class)->group(function() {
            Route::get('/products', 'index')->name('products.index');
            Route::get('/products/create', 'create')->name('products.create');
            Route::post('/products', 'store')->name('products.store');
            Route::get('/products/{product}/edit', 'edit')->name('products.edit');
            Route::put('/products/{product}', 'update')->name('products.update');
            Route::delete('/products/{product}', 'destroy')->name('products.delete');
            Route::get('/get-products','getProducts')->name('products.getProducts');            
        });

        //Sub Categories Connect to main Categories
        Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('product-subcategories.index');
        Route::get('/product-subsubcategories', [ProductSubCategoryController::class, 'getSubSubCategories'])->name('product-subcategories.extra');

        //Delete Product Images Route
        Route::post('/product-images/update', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/product-images', [ProductImageController::class, 'destroy'])->name('product-images.destroy');

        //Shipping Routes
        Route::controller(ShippingController::class)->group(function() {
            Route::get('/shipping/index', 'index')->name('shipping.index');
            Route::post('/shipping', 'store')->name('shipping.store');
            Route::delete('/shipping/{id}', 'destroy')->name('shipping.delete');
        });

        //Coupon Code Routes
        Route::controller(DiscountCodeController::class)->group(function() {
            Route::get('/coupons', 'index')->name('coupons.index');            
            Route::post('/coupons', 'store')->name('coupons.store');
            Route::get('/coupons/{coupon}/edit', 'edit')->name('coupons.edit');
            Route::put('/coupons/{coupon}', 'update')->name('coupons.update');
            Route::delete('/coupons/{coupon}', 'destroy')->name('coupons.delete');
        });

        //Orders Routes
        Route::controller(OrderController::class)->group(function() {
            Route::get('/orders', 'index')->name('orders.index');
            Route::get('/orders/{id}', 'detail')->name('orders.detail');
            Route::post('/order/change-status/{id}', 'changeOrderStatus')->name('orders.changeOrderStatus');
            Route::post('/order/send-email/{id}', 'sendInvoiceEmail')->name('orders.sendInvoiceEmail');
        });

        //Users Routes
        Route::controller(UserController::class)->group(function() {
            Route::get('/users', 'index')->name('users.index');            
            Route::post('/users', 'store')->name('users.store');
            Route::get('/users/{user}/edit', 'edit')->name('users.edit');
            Route::put('/users/{user}', 'update')->name('users.update');
            Route::delete('/users/{user}', 'destroy')->name('users.delete');
        });

        //Pages Routes
        Route::controller(PageController::class)->group(function() {
            Route::get('/pages', 'index')->name('pages.index');
            Route::get('/pages/create', 'create')->name('pages.create');
            Route::post('/pages', 'store')->name('pages.store');
            Route::get('/pages/{page}/edit', 'edit')->name('pages.edit');
            Route::put('/pages/{page}', 'update')->name('pages.update');
            Route::delete('/pages/{page}', 'destroy')->name('pages.delete');
        });

        //Temp image controller
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        //Setting Route
        Route::get('/password', [SettingController::class, 'showChangePasswordForm'])->name('admin.showChangePasswordForm');
        Route::post('/process-change-password', [SettingController::class, 'processChangePassword'])->name('admin.processChangePassword');        

        Route::get('/getSlug', function(Request $request){
            $slug = '';
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    });
});
