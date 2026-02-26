<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\TempImagesController;
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
    Route::get('/product/{id}/reviews', 'allReviews')->name('product.reviews');
    Route::post('/rate-product', 'rating_store')->name('rate.product');
});

Route::controller(CartController::class)->group(function() {
    //Bag
    Route::get('/checkout/cart','cart')->name('front.cart');
    Route::post('/checkout/update-cart','updateCart')->name('front.updateCart');
    Route::post('/checkout/add-to-cart','addToCart')->name('front.addToCart');
    Route::post('/checkout/delete-item','deleteItem')->name('front.deleteItem.cart');

    //Update Color/Size/Qty in cart
    Route::post('/checkout/cart/common', 'updateCartOption')->name('front.updateCartOption');
    Route::post('/cart/update-item', 'updateItem')->name('front.updateCartItem');

    //Route::post('/update-cart','updateCart')->name('front.updateCart');
    Route::get('/checkout/address','checkout')->name('front.checkout');
    Route::post('/process-checkout','processCheckout')->name('front.processCheckout');
    Route::get('/thanks/{orderId}','thankyou')->name('front.checkout.thankyou');
    Route::post('/get-order-summary','getOrderSummary')->name('front.getOrderSummary');

    //Discount apply
    Route::post('/apply-coupon', 'applyCoupon')->name('coupon.apply');
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

            Route::post('/address/store', 'address_store')->name('customer.address.store');
            Route::put('/address/{id}', 'address_update')->name('customer.address.update');

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
        Route::controller(ProductSubCategoryController::class)->group(function() {
            Route::get('/product-subcategories', 'index')->name('product-subcategories.index');
            Route::get('/product-subsubcategories', 'getSubSubCategories')->name('product-subcategories.extra');
        });

        //Delete Product Images Route
        Route::controller(ProductImageController::class)->group(function() {
            Route::post('/product-images/update', 'update')->name('product-images.update');
            Route::delete('/product-images', 'destroy')->name('product-images.destroy');
        });
        
        //Orders Routes
        Route::controller(OrderController::class)->group(function() {
            Route::get('/orders', 'index')->name('orders.index');
            Route::get('/orders/{id}', 'detail')->name('orders.detail');
            Route::post('/order/change-status/{id}', 'changeOrderStatus')->name('orders.changeOrderStatus');
            Route::post('/order/send-email/{id}', 'sendInvoiceEmail')->name('orders.sendInvoiceEmail');
        });          

        //Temp image controller
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        //Settings
        
        Route::controller(SettingController::class)->group(function() {
            Route::get('/password', 'showChangePasswordForm')->name('admin.showChangePasswordForm');
            Route::post('/process-change-password', 'processChangePassword')->name('admin.processChangePassword');        

            //Brands
            Route::get('/settings/brands', 'brand_index')->name('brands.index');            
            Route::post('/settings/brands', 'brand_store')->name('brands.store');            
            Route::delete('/settings/brands/{brand}', 'brand_destroy')->name('brands.delete');

            //Colors
            Route::get('/settings/colors', 'color_index')->name('colors.index');            
            Route::post('/settings/colors', 'color_store')->name('colors.store');            
            Route::delete('/settings/colors/{color}', 'color_destroy')->name('colors.delete');

            //Discount coupon
            Route::get('/settings/coupons', 'coupon_index')->name('coupons.index');            
            Route::post('/settings/coupons', 'coupon_store')->name('coupons.store');
            Route::get('/settings/coupons/{coupon}/edit', 'coupon_edit')->name('coupons.edit');
            Route::put('/settings/coupons/{coupon}', 'coupon_update')->name('coupons.update');
            Route::delete('/settings/coupons/{coupon}', 'coupon_destroy')->name('coupons.delete');

            //Pages
            Route::get('/settings/pages', 'page_index')->name('pages.index');
            Route::get('/settings/pages/create', 'page_create')->name('pages.create');
            Route::post('/settings/pages', 'page_store')->name('pages.store');
            Route::get('/settings/pages/{page}/edit', 'page_edit')->name('pages.edit');
            Route::put('/settings/pages/{page}', 'page_update')->name('pages.update');
            Route::delete('/settings/pages/{page}', 'page_destroy')->name('pages.delete');

            //Users
            Route::get('/settings/users', 'users_index')->name('users.index');            
            Route::post('/settings/users', 'users_store')->name('users.store');
            Route::get('/settings/users/{user}/edit', 'users_edit')->name('users.edit');
            Route::put('/settings/users/{user}', 'users_update')->name('users.update');
            Route::delete('/settings/users/{user}', 'users_destroy')->name('users.delete');

            //Shipping
            Route::get('/settings/shipping/index', 'shipping_index')->name('shipping.index');
            Route::post('/settings/shipping', 'shipping_store')->name('shipping.store');
            Route::delete('/settings/shipping/{id}', 'shipping_destroy')->name('shipping.delete');
        });  
           

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
