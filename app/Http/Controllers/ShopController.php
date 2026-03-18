<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\DiscountCoupon;
use App\Models\DiscountPercentage;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller {
    public function index(Request $request, $item1=null, $item2=null, $item3=null) {    
        $filtersArray = [
            'brands'   => [],
            'colors'   => [],
            'sizes'    => [],
            'discount' => [],
        ];

        $selectedItems = [
            'item1' => null,
            'item2' => null,
            'item3' => null,
        ];
        
        $categories = Category::orderBy("category_name","ASC")->with(['sub_category'])->where('status',1)->get();               
        $products = Product::with('ratings')->where('status',1);
        $productCount = Product::where('status', 1)->count();
        $totalProducts = $products->count();     
        
        function applySlugFilter($slug, $model, $slugColumn, $productColumn, &$selectedItem, &$products){
            if (!empty($slug)) {
                $selectedItem = $model::where($slugColumn, $slug)->first();
                if ($selectedItem) {
                    $products->where($productColumn, $selectedItem->id);
                }
            }
        }

        applySlugFilter($item1, Category::class, 'category_slug', 'category_id', $selected_item1, $products);
        applySlugFilter($item2, SubCategory::class, 'sub_category_slug', 'sub_category_id', $selected_item2, $products);
        applySlugFilter($item3, SubSubCategory::class, 'sub_sub_category_slug', 'sub_sub_category_id', $selected_item3, $products);

        $item3 = collect();

        if ($selected_item2) {
            $item3 = SubSubCategory::where('sub_category_id', $selected_item2->id)
                ->withCount(['products' => function ($query) {
                    $query->where('status', 1);
                }])
                ->get();
        }

        $filterProducts = function ($query) use ($selected_item1, $selected_item2) {
            $query->where('status', 1);
            if ($selected_item1) {$query->where('category_id', $selected_item1->id);}
            if ($selected_item2) {$query->where('sub_category_id', $selected_item2->id);}
        };

        $brands = Brand::where('status',1)->withCount(['products as products_count' => $filterProducts])->orderBy('name','ASC')->get();        
        $colors = Color::withCount(['products as products_count' => $filterProducts])->orderBy('name','ASC')->get();
        $sizes = Size::withCount(['products as products_count' => $filterProducts])->orderBy('name','ASC')->get();
        $discounts = DiscountPercentage::withCount(['products as products_count' => $filterProducts])->orderBy('name','ASC')->get();

        //Filter logic
        function applyFilter($request, $param, $model, $column, $productColumn, &$selectedArray, &$products) {
            if (!empty($request->get($param))) {
                $values = explode(',', $request->get($param));
                $ids = $model::whereIn($column, $values)->pluck('id')->toArray();
                $selectedArray = $values;
                $products->whereIn($productColumn, $ids);
            }
        }

        applyFilter($request, 'brand', Brand::class, 'slug', 'brand_id', $brandsArray, $products);
        applyFilter($request, 'color', Color::class, 'name', 'color_id', $colorsArray, $products);
        applyFilter($request, 'size', Size::class, 'name', 'size_id', $sizesArray, $products);
        applyFilter($request, 'discount', DiscountPercentage::class, 'name', 'discount_percentage_id', $discountArray, $products);
            
        // Price slider
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $min = intval($request->get('price_min'));
            $max = intval($request->get('price_max'));
            $products = $products->whereBetween('price', [$min, $max]);
        }

        //Search main header
        if (!empty($request->get('search'))){
            $products = $products->where('title','like','%'.$request->get('search').'%');
        }

        //Sort filters
        if ($request->get('sort') != '') {
            switch ($request->get('sort')) {
                case 'latest':
                    $products = $products->orderBy('id', 'DESC');
                    break;

                case 'price_asc':
                    $products = $products->orderBy('price', 'ASC');
                    break;

                case 'price_desc':
                    $products = $products->orderBy('price', 'DESC');
                    break;

                case 'recommended':
                    $products = $products->orderBy('recommended', 'DESC');
                    break;

                case 'popularity':
                    $products = $products->orderBy('views', 'DESC');
                    break;

                case 'discount':
                    $products = $products->orderBy('discount_percentage', 'DESC');
                    break;

                case 'rating':
                    $products = $products->orderBy('average_rating', 'DESC');
                    break;

                default:
                    $products = $products->orderBy('id', 'DESC');
            }

        } else {
            $products = $products->orderBy('id', 'DESC');
        }

        $filtersApplied = false;

        if (
            $request->filled('brand') ||
            $request->filled('color') ||
            $request->filled('size') ||
            $request->filled('item') ||
            $request->filled('price_min') ||
            $request->filled('price_max') ||
            $request->filled('sort') ||
            $request->filled('discount') ||
            $request->filled('search')
        ) {
            $filtersApplied = true;
        }               

        // Coupon filter
        if ($request->coupon) {
            $products->whereHas('coupons', function ($q) use ($request) {
                $q->where('code', $request->coupon);
            });
        }
        // if ($request->coupon) {
        //     $coupon = DiscountCoupon::where('code', $request->coupon)->first();
        //     if ($coupon) {
        //         $products->whereHas('coupons', function ($q) use ($coupon) {
        //             $q->where('discount_coupons.id', $coupon->id);
        //         });
        //     } else {
        //         $products->whereRaw('0=1'); 
        //     }
        // }

        $products = $products->paginate(10);
       
        return view('front.shop.index', compact(
            'categories', 'brands', 'brandsArray', 'colors', 'colorsArray', 'sizes', 'sizesArray', 
            'discounts', 'discountArray', 'products', 'productCount', 'selected_item1', 
            'selected_item2', 'selected_item3', 'item3', 'filtersApplied', 'totalProducts'
        ) + [
            'priceMin' => $request->get('price_min', 0),
            'priceMax' => $request->get('price_max', 5000),
            'sort'     => $request->get('sort'),
        ]);
    }


    public function product($slug, Request $request){        
        $product = Product::where('slug',$slug)->with(['product_images', 'variants', 'subSubCategory.subCategory.category'])->first();
        $colors = Color::get();
        $sizes = Size::get();

        $products = Product::query();

        if($request->coupon){

            $coupon = DiscountCoupon::where('code',$request->coupon)->first();

            if($coupon){
                $products->whereHas('coupons', function($q) use ($coupon){
                    $q->where('discount_coupons.id',$coupon->id);
                });
            }
        }
                    
        $coupon = $request->coupon;        
        if($request->coupon){
            $coupon = DiscountCoupon::where('code', $request->coupon)->first();

            if(!$coupon){
                abort(404);
            }
            // check if coupon valid for this product
            if(!$product->coupons()->where('discount_coupons_id',$coupon->id)->exists()){
                abort(404);
            }
            session(['coupon'=>$coupon]);
        }

        $selectedVariant = null;

        if ($request->filled('variant')) {
            $selectedVariant = $product->variants
                                ->where('id', $request->variant)
                                ->first();
        }

        if($product == null){
            abort(404);
        }

        $selected_item1 = null;
        $selected_item2 = null;
        $selected_item3 = null;

        if (!empty($categorySlug)) {
            $selected_item1 = Category::where('category_slug', $categorySlug)->first();
            if ($selected_item1) {
                $products = $product->where('category_id', $selected_item1->id);
            }
        }

        if (!empty($subCategorySlug)) {
            $selected_item2 = SubCategory::where('sub_category_slug', $subCategorySlug)->first();
            if ($selected_item2) {
                $products = $products->where('sub_category_id', $selected_item2->id);
            }
        }

        if (!empty($subSubCategory)) {
            $selected_item3 = SubSubCategory::where('sub_sub_category_slug', $subSubCategory)->first();
            if ($selected_item3) {
                $products = $products->where('sub_sub_category_id', $selected_item3->id);
            }
        }

        //Fetch Related products
        $relatedProducts = [];
        if ($product->related_products != '') {
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->where('status',1)->with('product_images')->get();
        }

        $ratings = Review::where('product_id', $product->id)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count','rating')
            ->toArray();

        for ($i = 1; $i <= 5; $i++) {
            $ratings[$i] = $ratings[$i] ?? 0;
        }

        krsort($ratings);                    
        
        $totalRatings = Review::where('product_id', $product->id)->count();
        $averageRating = Review::avg('rating');
        $reviews = Review::with('user')->where('product_id', $product->id)->latest()->take(3)->get();      
        $totalReviews = Review::where('product_id', $product->id)->count();         
       
        $data['product'] = $product;
        $data['coupon'] = $coupon;
        $data['selectedVariant'] = $selectedVariant;
        $data['ratings'] = $ratings;
        $data['totalRatings'] = $totalRatings;
        $data['averageRating'] = $averageRating;
        $data['reviews'] = $reviews;
        $data['totalReviews'] = $totalReviews;
        $data['colors'] = $colors;        
        $data['sizes'] = $sizes;
        $data['relatedProducts'] = $relatedProducts;
        $data['selected_item1'] = $selected_item1;
        $data['selected_item2'] = $selected_item2;
        $data['selected_item3'] = $selected_item3;

        return view('front.products.index',$data);
    }
    

    // public function coupon_product($slug, $coupon, $request) {
    //     $product = Product::findOrFail($slug);

    //     if($request->coupon){
    //         $coupon = DiscountCoupon::where('code',$request->coupon)
    //                         ->whereDate('expiry_date','>=',now())
    //                         ->first();
    //         if(!$coupon || !$product->coupons()->where('coupon_id',$coupon->id)->exists()){
    //             abort(404);
    //         }
    //         session(['coupon'=>$coupon]);
    //     }

    //     return view('front.products.index', compact('product'));
    // }


    public function allReviews($id) {
        $product = Product::findOrFail($id);
        $reviews = Review::where('product_id', $id)
                    ->latest()
                    ->paginate(10); // pagination

        $averageRating = Review::avg('rating');        
        $ratings = Review::where('product_id', $product->id)
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count','rating')
            ->toArray();

        for ($i = 1; $i <= 5; $i++) {
            $ratings[$i] = $ratings[$i] ?? 0;
        }

        krsort($ratings);
        $totalRatings = Review::where('product_id', $product->id)->count();

        return view('front.products.reviews', compact('product','reviews','averageRating', 'ratings', 'totalRatings'));
    }


    public function category(Request $request, $categorySlug = null) {
        $categorySelected = ' ';        

        $categories = Category::orderBy("category_name","ASC")->with('sub_category')->where('status',1)->get();
        $products = Product::where('status',1);        

        //Apply filters here
        if (!empty($categorySlug)) {
            $category = Category::where('category_slug', $categorySlug)->first();
            if ($category) {
                $products = $products->where('category_id', $category->id);
                $categorySelected = $category->id;
            }
        }
       
        $products = $products->paginate(10);

        $data['categories'] = $categories;
        $data['products'] = $products;
        $data['categorySelected'] = $categorySelected;

        return view('front.shop.category',$data);
    }


    public function store(Request $request) {
        Rating::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'review' => $request->review
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thanks for your rating!'
        ]);
    }
}
