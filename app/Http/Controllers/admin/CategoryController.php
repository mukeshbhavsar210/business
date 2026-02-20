<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Flash;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rule;

class CategoryController extends Controller {

    public function index(Request $request) {
        // Categories
        $categories = Category::orderBy('menu_order', 'asc');

        if ($request->filled('keyword')) {
            $categories->where('category_name', 'like', '%' . $request->keyword . '%');
        }

        $categories = $categories->paginate(10);



        // Sub Categories
        $subCategories = SubCategory::select(
                'sub_categories.*',
                'categories.category_name as categoryName'
            )
            ->leftJoin('categories', 'categories.id', 'sub_categories.category_id')
            ->latest('sub_categories.id');

        if ($request->filled('keyword2')) {
            $keyword = $request->keyword;

            $subCategories->where(function ($query) use ($keyword) {
                $query->where('sub_categories.sub_category_name', 'like', "%$keyword%")
                    ->orWhere('categories.sub_category_name', 'like', "%$keyword%");
            });
        }

        $subCategories = $subCategories->paginate(10);



        // Sub Sub Categories
        $sub2Categories = SubSubCategory::select(
                'sub_sub_categories.*',
                'sub_categories.sub_category_name as subCategoryName',
                'categories.category_name as categoryName'
            )
            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'sub_sub_categories.sub_category_id')
            ->leftJoin('categories', 'categories.id', '=', 'sub_sub_categories.category_id')
            ->latest('sub_sub_categories.id');

        if ($request->filled('keyword3')) {
            $keyword = $request->keyword;

            $sub2Categories->where(function ($query) use ($keyword) {
                $query->where('sub_sub_categories.sub_category_name', 'like', "%$keyword%")
                    ->orWhere('sub_categories.sub_category_name', 'like', "%$keyword%")
                    ->orWhere('categories.sub_category_name', 'like', "%$keyword%");
            });
        }

        $sub2Categories = $sub2Categories->paginate(10);

        return view('admin.category.index', compact(
            'categories',
            'subCategories',
            'sub2Categories'
        ));
    }


    public function category_store(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
            'category_slug' => 'required|unique:sub_categories,category_slug',
            'menu_order' => 'required|integer|unique:categories,menu_order'
        ]);

        if ($validator->passes()) {
            $category = new Category();
            $category->category_name = $request->category_name;
            $category->category_slug = $request->category_slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->menu_order = $request->menu_order;
            $category->save();

            // Save image here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'_'.$category->name.'.'.$ext;                
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;                
                File::copy($sPath,$dPath);

                //Generate thumbnail
                $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($sPath);
                $image->cover(300,300);
                $image->save($dPath);
                $image->save($dPath);                                  
                $category->image = $newImageName;
                $category->save();
            }

            $request->session()->flash('success', 'Category added successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category added successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function sub_category_store(Request $request){
        $validator = Validator::make($request->all(), [
            'sub_category_name' => 'required',             
            // 'slug' => 'required|unique:sub_categories',
            'sub_category_slug' => [
                    'required',
                    Rule::unique('sub_categories')
                        ->where(function ($query) use ($request) {
                            return $query->where('category_id', $request->category_id);
                        }),
                ],
            'category_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $subCategory = new SubCategory();
            $subCategory->sub_category_name = $request->sub_category_name;
            $subCategory->sub_category_slug = $request->sub_category_slug;
            $subCategory->status = $request->status;
            $subCategory->category_id = $request->category_id;
            $subCategory->showHome = $request->showHome;
            $subCategory->save();

            $request->session()->flash('success', 'Sub Category added successfully');

            return response([
                'status' => true,
                'message' => 'Sub Category added successfully',
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }


    public function sub2_category_store(Request $request){
        $validator = Validator::make($request->all(), [
            'sub2_category_name' => 'required',
            // 'slug' => [
            //     'required',
            //     Rule::unique('sub_sub_categories')
            //         ->where(function ($query) use ($request) {
            //             return $query->where('sub_category_id', $request->sub_category_id);
            //         }),
            // ],
            //'slug' => 'required|unique:sub_sub_categories',
            //'category' => 'required',
            //'sub_category' => 'required',            
        ]);

        if ($validator->passes()) {
            $sub2Category = new SubSubCategory();
            $sub2Category->category_id = $request->category;
            $sub2Category->sub_category_id = $request->sub_category_id;
            $sub2Category->sub2_category_name = $request->sub2_category_name;
            $sub2Category->sub2_category_slug = $request->sub2_category_slug;            
            $sub2Category->save();

            $request->session()->flash('success', 'Sub2 Category added successfully');

            return response([
                'status' => true,
                'message' => 'Sub2 Category added successfully',
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function getSubCategories($id) {
        return SubCategory::where('category_id', $id)->get();
    }

    public function category_edit($categoryId, Request $request){
        $category = Category::find($categoryId);

        if (empty($category)) {
            return redirect()->route('categories.index');
        }

        return view('admin.category.category_edit', compact('category'));
    }


    public function category_update($categoryId, Request $request){
        $category = Category::find($categoryId);

        if (empty($category)) {
            $request->session()->flash('error', 'Category not found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
            'category_slug' => 'required|unique:categories,category_slug,'.$category->id.',id',
        ]);

        if ($validator->passes()) {
            $category->category_name = $request->category_name;
            $category->category_slug = $request->category_slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->menu_order = $request->menu_order;
            $category->save();

            $oldImage = $category->image;

            // Save image here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.',$tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($sPath,$dPath);

                //Generate image thumbnail
                $dPath = public_path().'/uploads/category/thumb/'.$newImageName;
                File::copy($sPath,$dPath);

                $category->image = $newImageName;
                $category->save();

                //Delete old image
                File::delete(public_path().'/uploads/category/thumb/'.$oldImage);
                File::delete(public_path().'/uploads/category/'.$oldImage);
            }

            $request->session()->flash('success', 'Category updated successfully');

            return response()->json([
                'status' => true,
                'message' => 'Category updated successfully'
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function category_destroy($categoryId, Request $request){
        $category = Category::find($categoryId);

        if(empty($category)){
            $request->session()->flash('error', 'Category not found');
            return response()->json([
                'status' => true,
                'message' => 'Category not found'
            ]);
            //return redirect()->route('categories.index');
        }

        //Delete old image
        File::delete(public_path().'/uploads/category/thumb/'.$category->image);
        File::delete(public_path().'/uploads/category/'.$category->image);

        $category->delete();

        $request->session()->flash('success', 'Category deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }


    public function sub_category_destroy ($id, Request $request){
        $subCategory = SubCategory::find($id);

        if(empty($subCategory)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $subCategory->delete();

        $request->session()->flash('success', 'Sub Category deleted successfully');

        return response([
            'status' => true,
            'message' => 'Sub Category deleted successfully',
        ]);
    }


    public function sub2_category_destroy($id, Request $request){
        $sub2Category = SubSubCategory::find($id);

        if(empty($sub2Category)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $sub2Category->delete();

        $request->session()->flash('success', 'Sub2 Category deleted successfully');

        return response([
            'status' => true,
            'message' => 'Sub2 Category deleted successfully',
        ]);
    }



     public function sub_category_edit($id, Request $request){
        $subCategory = SubCategory::find($id);
        if(empty($subCategory)){
            $request->session()->flash('error','Record not found');
            return redirect()->route('sub-categories.index');
        }

        $categories = Category::orderBy('category_name','ASC')->get();
        $data['categories'] = $categories;
        $data['subCategory'] = $subCategory;
        return view("admin.category.subcategory_edit", $data);
    }


    public function sub_category_update($id, Request $request){
        $subCategory = SubCategory::find($id);

        if(empty($subCategory)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'sub_category_name' => 'required',
            'sub_category_slug' => 'required|unique:sub_categories,sub_category_slug,'.$subCategory->id.',id',
            'category' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $subCategory->sub_category_name = $request->sub_category_name;
            $subCategory->sub_category_slug = $request->sub_category_slug;
            $subCategory->status = $request->status;
            $subCategory->showHome = $request->showHome;
            $subCategory->category_id = $request->category;
            $subCategory->save();

            $request->session()->flash('success', 'Sub Category updated successfully');

            return response([
                'status' => true,
                'message' => 'Sub Category updated successfully',
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }



    public function sub2_category_edit($id, Request $request) {
        $sub2Category = SubSubCategory::findOrFail($id);

        $categories = Category::orderBy('category_name','ASC')->get();

        // Load subcategories of selected category
        $subCategories = SubCategory::where('category_id', $sub2Category->category_id)->get();

        return view("admin.category.sub2category_edit", compact(
            'sub2Category',
            'categories',
            'subCategories'
        ));
    }


    public function sub2_category_update($id, Request $request){
        $sub2Category = SubSubCategory::find($id);

        if(empty($sub2Category)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $validator = Validator::make($request->all(), [
            //'sub2_category_name' => 'required',
            //'slug' => 'required|unique:sub_sub_categories,slug,'.$sub2Category->id.',id',
            //'category' => 'required',                        
        ]);

        if ($validator->passes()) {
            $sub2Category->category_id = $request->category_id;
            $sub2Category->sub_category_id = $request->sub_category_id;
            $sub2Category->sub2_category_name = $request->sub2_category_name;
            $sub2Category->sub2_category_slug = $request->sub2_category_slug;                   
            $sub2Category->save();

            $request->session()->flash('success', 'Sub2 Category updated successfully');

            return response([
                'status' => true,
                'message' => 'Sub2 Category updated successfully',
            ]);

        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
}
