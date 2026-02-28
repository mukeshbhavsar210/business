<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller {
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null, $subSubCategory = null) {
        $brandsArray = [];
        $colorsArray = [];
        $sizesArray = [];
        
        $categories = Category::orderBy("category_name","ASC")->with(['sub_category'])->where('status',1)->get();               
        $products = Product::with('ratings')->where('status',1);
        $productCount = Product::where('status', 1)->count();
        $totalProducts = $products->count();

        $selectedCategory = null;
        $selectedSubCategory = null;
        $selectedSubSubCategory = null;

        if (!empty($categorySlug)) {
            $selectedCategory = Category::where('category_slug', $categorySlug)->first();
            if ($selectedCategory) {
                $products = $products->where('category_id', $selectedCategory->id);
            }
        }

        if (!empty($subCategorySlug)) {
            $selectedSubCategory = SubCategory::where('sub_category_slug', $subCategorySlug)->first();
            if ($selectedSubCategory) {
                $products = $products->where('sub_category_id', $selectedSubCategory->id);
            }
        }

        if (!empty($subSubCategory)) {
            $selectedSubSubCategory = SubSubCategory::where('sub2_category_slug', $subSubCategory)->first();
            if ($selectedSubSubCategory) {
                $products = $products->where('sub_sub_category_id', $selectedSubSubCategory->id);
            }
        }

        $subSubCategories = collect();

        if ($selectedSubCategory) {
            $subSubCategories = SubSubCategory::where('sub_category_id', $selectedSubCategory->id)
                ->withCount(['products' => function ($query) {
                    $query->where('status', 1);
                }])
                ->get();
        }

        $brands = Brand::where('status',1)
            ->withCount(['products as products_count' => function($query) use ($selectedCategory, $selectedSubCategory) {
                $query->where('status',1);
                if ($selectedCategory) {
                    $query->where('category_id', $selectedCategory->id);
                }

                if ($selectedSubCategory) {
                    $query->where('sub_category_id', $selectedSubCategory->id);
                }

            }])
            ->orderBy('name','ASC')
            ->get();

        $colors = Color::withCount([
            'products as products_count' => function($query) use ($selectedCategory, $selectedSubCategory) {
                $query->where('status', 1);
                if ($selectedCategory) {
                    $query->where('category_id', $selectedCategory->id);
                }
                if ($selectedSubCategory) {
                    $query->where('sub_category_id', $selectedSubCategory->id);
                }
            }
        ])
        ->orderBy('name','ASC')
        ->get();

        $sizes = Size::withCount([
            'products as products_count' => function($query) use ($selectedCategory, $selectedSubCategory) {
                $query->where('status', 1);
                if ($selectedCategory) {
                    $query->where('category_id', $selectedCategory->id);
                }
                if ($selectedSubCategory) {
                    $query->where('sub_category_id', $selectedSubCategory->id);
                }
            }
        ])
        ->orderBy('name','ASC')
        ->get();

        // brands filters
        if (!empty($request->get('brand'))) {
            $brandSlugs = explode(',', $request->get('brand'));
            $brandIds = Brand::whereIn('slug', $brandSlugs)
                ->pluck('id')
                ->toArray();

            $brandsArray = $brandSlugs; // for checkbox checked state
            $products = $products->whereIn('brand_id', $brandIds);
        }

        // colors filters
        if (!empty($request->get('color'))) {
            $colorCode = explode(',', $request->get('color'));
            $colorIds = Color::whereIn('name', $colorCode)
                ->pluck('id')
                ->toArray();

            $colorsArray = $colorCode; 
            $products = $products->whereIn('color_id', $colorIds);
        }

        // size filters
        if (!empty($request->get('size'))) {
            $sizeCode = explode(',', $request->get('size'));
            $sizeIds = Size::whereIn('name', $sizeCode)
                ->pluck('id')
                ->toArray();

            $sizesArray = $sizeCode; 
            $products = $products->whereIn('size_id', $sizeIds);
        }

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
            $request->filled('sub2') ||
            $request->filled('price_min') ||
            $request->filled('price_max') ||
            $request->filled('sort') ||
            $request->filled('search')
        ) {
            $filtersApplied = true;
        }

        $products = $products->paginate(10);

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        $data['brandsArray'] = $brandsArray;
        $data['colors'] = $colors;
        $data['colorsArray'] = $colorsArray;
        $data['sizes'] = $sizes;
        $data['sizesArray'] = $sizesArray;
        $data['products'] = $products;
        $data['productCount '] = $productCount;
        $data['selectedCategory'] = $selectedCategory;
        $data['selectedSubCategory'] = $selectedSubCategory;
        $data['selectedSubSubCategory'] = $selectedSubSubCategory;
        $data['subSubCategories'] = $subSubCategories;
        
        $data['priceMin'] = $request->get('price_min') ?? 0;
        $data['priceMax'] = $request->get('price_max') ?? 5000;
        $data['sort'] = $request->get('sort');
        $data['filtersApplied'] = $filtersApplied;
        $data['totalProducts'] = $totalProducts;

        return view('front.shop.index',$data);
    }

    


    public function product($slug, Request $request){        
        $product = Product::where('slug',$slug)->with(['product_images', 'variants', 'subSubCategory.subCategory.category'])->first();
        $colors = Color::get();
        $sizes = Size::get();

        $selectedVariant = null;

        if ($request->filled('variant')) {
            $selectedVariant = $product->variants
                                ->where('id', $request->variant)
                                ->first();
        }

        if($product == null){
            abort(404);
        }

        $selectedCategory = null;
        $selectedSubCategory = null;
        $selectedSubSubCategory = null;

        if (!empty($categorySlug)) {
            $selectedCategory = Category::where('category_slug', $categorySlug)->first();
            if ($selectedCategory) {
                $products = $product->where('category_id', $selectedCategory->id);
            }
        }

        if (!empty($subCategorySlug)) {
            $selectedSubCategory = SubCategory::where('sub_category_slug', $subCategorySlug)->first();
            if ($selectedSubCategory) {
                $products = $products->where('sub_category_id', $selectedSubCategory->id);
            }
        }

        if (!empty($subSubCategory)) {
            $selectedSubSubCategory = SubSubCategory::where('sub2_category_slug', $subSubCategory)->first();
            if ($selectedSubSubCategory) {
                $products = $products->where('sub_sub_category_id', $selectedSubSubCategory->id);
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
        $data['selectedVariant'] = $selectedVariant;
        $data['ratings'] = $ratings;
        $data['totalRatings'] = $totalRatings;
        $data['averageRating'] = $averageRating;
        $data['reviews'] = $reviews;
        $data['totalReviews'] = $totalReviews;
        $data['colors'] = $colors;        
        $data['sizes'] = $sizes;
        $data['relatedProducts'] = $relatedProducts;
        $data['selectedCategory'] = $selectedCategory;
        $data['selectedSubCategory'] = $selectedSubCategory;
        $data['selectedSubSubCategory'] = $selectedSubSubCategory;

        return view('front.products.index',$data);
    }


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
