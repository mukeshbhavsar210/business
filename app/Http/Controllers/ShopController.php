<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;

class ShopController extends Controller {
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null, $subSubCategory = null) {
        // $categorySelected = ' ';
        // $subCategorySelected = ' ';
        // $subSubCategorySelected = ' ';
        $brandsArray = [];
        $colorsArray = [];

        $categories = Category::orderBy("category_name","ASC")->with('sub_category')->where('status',1)->get();               
        $products = Product::where('status',1);
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


    public function product($slug){
        $product = Product::where('slug',$slug)->with('product_images')->first();

        if($product == null){
            abort(404);
        }

        //Fetch Related products
        $relatedProducts = [];
        if ($product->related_products != '') {
            $productArray = explode(',',$product->related_products);
            $relatedProducts = Product::whereIn('id',$productArray)->where('status',1)->with('product_images')->get();
        }

        $data['product'] = $product;
        $data['relatedProducts'] = $relatedProducts;


        return view('front.products.index',$data);
    }
}
