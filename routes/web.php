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

Route::get('/shop/{categorySlug?}/{subCategorySlug?}',[ShopController::class,'index'])->name('front.shop');
Route::get('/product/{slug}',[ShopController::class,'product'])->name('front.product');

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
            Route::get('/change-password','changePasswordForm')->name('account.changePassword');
            Route::post('/process-change-password','changePassword')->name('account.processChangePassword');
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
            Route::get('/categories/category', 'index')->name('categories.index');
            Route::get('/categories/category/create', 'create')->name('categories.create');
            Route::post('/categories/category/', 'categoryStore')->name('categories.category.store');
            Route::post('/categories/sub-category/', 'subCategoryStore')->name('categories.subCategory.store');
            Route::post('/categories/sub2-category/', 'sub2CategoryStore')->name('categories.sub2Category.store');

            Route::get('/categories/category/{category}/edit', 'edit')->name('categories.edit');
            Route::put('/categories/category/{category}', 'update')->name('categories.update');
            Route::delete('/categories/category/{category}', 'destroy')->name('categories.delete');
            Route::delete('/categories/sub/category/{subCategory}', 'destroySubCategory')->name('subCategories.delete');
            Route::delete('/categories/sub2/category/{sub2Category}', 'destroySub2Category')->name('sub2Categories.delete');

            Route::get('/get-subcategories/{id}', 'getSubCategories')->name('get.subcategories');
        });

        //Sub Category Routes
        Route::controller(SubCategoryController::class)->group(function() {
            //Route::get('/categories/sub', 'index')->name('sub-categories.index');
            Route::get('/categories/sub/create', 'create')->name('sub-categories.create');
            Route::post('/categories/sub', 'store')->name('sub-categories.store');
            Route::get('/categories/sub/{subCategory}/edit', 'edit')->name('sub-categories.edit');
            Route::put('/categories/sub/{subCategory}', 'update')->name('sub-categories.update');
            //Route::delete('/categories/sub/{subCategory}', 'destroy')->name('sub-categories.delete');            
        });

        //Sub Category Routes
        Route::controller(Sub2CategoryController::class)->group(function() {
            //Route::get('/categories/sub2', 'index')->name('sub2-categories.index');
            Route::get('/categories/sub2/create', 'create')->name('sub2-categories.create');
            Route::post('/categories/sub2', 'store')->name('sub2-categories.store');
            Route::get('/categories/sub2/{subCategory}/edit', 'edit')->name('sub2-categories.edit');
            Route::put('/categories/sub2/{subCategory}', 'update')->name('sub2-categories.update');
            //Route::delete('/categories/sub2/{subCategory}', 'destroy')->name('sub2-categories.delete');
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
        Route::get('/change-password', [SettingController::class, 'showChangePasswordForm'])->name('admin.showChangePasswordForm');
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
