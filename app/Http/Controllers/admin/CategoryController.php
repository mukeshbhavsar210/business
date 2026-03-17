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
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller {

    public function index(Request $request) {        
        $categories = Category::withCount('subCategories')
            ->with(['subCategories' => function ($q) {
                $q->withCount('subSubCategories')
                ->with('subSubCategories');
            }])
            ->orderBy('menu_order', 'asc')
            ->paginate(10);        

        if ($request->filled('keyword')) {
            $categories->where('category_name', 'like', '%' . $request->keyword . '%');
        }        

        $categoryTotal = Category::count();        

        $data = [                                 
            'refresh'       => route('categories.index'),
            'total'         => $categoryTotal,
            'modals' => [
                'category' => [
                    'title'      => 'Create Category',
                    'modal_id'   => 'categoryModal',
                    'form_id'    => 'categoryForm',
                    'method_id'  => 'category_method',
                    'formConfig' => [
                        'action' => '',
                        'method' => 'POST',
                        'button' => 'Submit',
                        'fields' => [
                            [
                                'type' => 'text',
                                'name' => 'category_name',                                
                                'id' => 'category_name', 
                                'label' => 'Category Name',
                                'placeholder' => 'Enter Category name',
                                'slug_create' => 'slug-source',
                                'class' => 'slug-source',                                
                                'data'  => [
                                    'target' => '#slug'
                                ],
                                'col' => 'col-md-6 col-12'
                            ],
                            [
                                'type' => 'text',
                                'name' => 'category_slug',
                                'label' => 'Category slug',
                                'placeholder' => 'Enter Category name',                                
                                'id'    => 'slug',
                                'col' => 'col-md-12 col-12 d-none'
                            ],                                     
                            [
                                'type' => 'select',
                                'name' => 'menu_order',
                                'label' => 'Menu Order',
                                'options' => [
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                    4 => 4,
                                    5 => 5,
                                    6 => 6,
                                    7 => 7,
                                    8 => 8,
                                ],
                                'col' => 'col-md-3 col-6'
                            ],
                            [
                                'type' => 'select',
                                'name' => 'status',
                                'label' => 'Status',
                                'options' => [
                                    1 => 'Active',
                                    0 => 'Block'
                                ],
                                'col' => 'col-md-3 col-6'
                            ],
                            [
                                'type' => 'dropzone',
                                'name' => 'image',
                                'label' => 'Image'                        
                            ]
                        ]
                    ]
                ],                

                // Create Sub Category
                'subcategory' => [
                    'title'      => 'Create Sub Category',
                    'modal_id'   => 'subCategoryModal',
                    'form_id'    => 'subCategoryForm',
                    'method_id'  => 'subcategory_method',
                    'formConfig' => [
                        'action' => '',
                        'method' => 'POST',
                        'button' => 'Submit',
                        'fields' => [                            
                            [
                                'type' => 'select',
                                'name' => 'category_id',
                                'label' => 'Select Parent Category',
                                'options' => ['Select Category' => 'Select Category'] + $categories->pluck('category_name','id')->toArray(),
                                'col' => 'col-md-12 col-12'
                            ],   
                            [
                                'type' => 'text',
                                'name' => 'sub_category_name',
                                'label' => 'Sub Category Name',
                                'id' => 'sub_category_name',
                                'placeholder' => 'Enter Category name',
                                'slug_create' => 'slug-source',
                                'class' => 'slug-source',                                
                                'data'  => [
                                    'target' => '#slug_2'
                                ],
                                'col' => 'col-md-12 col-12'
                            ],                         
                            [
                                'type' => 'text',
                                'name' => 'sub_category_slug',
                                'label' => 'Category slug',
                                'placeholder' => 'Enter Category name',                                
                                'id'    => 'slug_2',
                                'col' => 'col-md-12 col-12  d-none'
                            ],                                     
                            [
                                'type' => 'select',
                                'name' => 'menu_order',
                                'label' => 'Menu Order',
                                'options' => [
                                    1 => 1,
                                    2 => 2,
                                    3 => 3,
                                    4 => 4,
                                    5 => 5,
                                    6 => 6,
                                    7 => 7,
                                    8 => 8,
                                ],
                                'col' => 'col-md-6 col-6'
                            ],
                            [
                                'type' => 'select',
                                'name' => 'status',
                                'label' => 'Status',
                                'options' => [
                                    1 => 'Active',
                                    0 => 'Block'
                                ],
                                'col' => 'col-md-6 col-6'
                            ],
                        ]
                    ]
                ],               
                
                'subsubcategory' => [
                    'title'      => 'Create Sub Sub Category',
                    'modal_id' => 'subSubCategoryModal',
                    'form_id' => 'subSubCategoryForm',
                    'method_id'  => 'subsubcategory_method',
                    'formConfig' => [
                        'action' => '',
                        'method' => 'POST',
                        'button' => 'Submit',
                        'fields' => [
                            [
                                'type' => 'select',
                                'name' => 'category_id',                                
                                'label' => 'Select Parent Category',
                                'options' => ['Select Category' => 'Select Category'] + $categories->pluck('category_name','id')->toArray(),                                
                                'col' => 'col-md-12 col-12'
                            ],
                            [
                                'type' => 'category',
                                'name' => 'sub_category_id',
                                'label' => 'Select Parent Sub Category',                                
                                'col' => 'col-md-12 col-12'
                            ],
                            [
                                'type' => 'text',
                                'name' => 'sub_sub_category_name',
                                'label' => 'Sub Sub Category Name',
                                'placeholder' => 'Enter Category name',
                                'slug_create' => 'slug-source',
                                'class' => 'slug-source',                                
                                'data'  => [
                                    'target' => '#slug_3'
                                ],
                                'col' => 'col-md-12 col-12'
                            ],
                            [
                                'type' => 'text',
                                'name' => 'sub_sub_category_slug',
                                'label' => 'Category slug',
                                'placeholder' => 'Enter Category name',                                
                                'id'    => 'slug_3',
                                'col' => 'col-md-12 col-12  d-none'
                            ],                            
                        ]
                    ]
                ],
            ],     
                         
            // 'delete' => [
            //     'modal_id' => 'deleteCategoryModal',
            //     'form_id' => 'deleteCategoryModalForm',
            //     'formConfig' => [
            //         'action' => '',
            //         'method' => 'DELETE',
            //         'button' => 'Delete',
            //         'fields' => []
            //     ]
            // ],

            'categories' => $categories
        ];          

        return view('admin.category.index', $data);       
    }

    public function category_store(Request $request){
        $validator = Validator::make($request->all(), [
            //'category_name' => 'required',
            //'category_slug' => 'required|unique:sub_categories,category_slug',
            //'menu_order' => 'required|integer|unique:categories,menu_order'
        ]);

        if ($validator->passes()) {
            $category = new Category();
            $category->category_name = $request->category_name;
            $category->category_slug = $request->category_slug;
            $category->status = $request->status;            
            $category->menu_order = $request->menu_order;
            $category->save();

            // Save image here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);

                if ($tempImage) {
                    $ext = pathinfo($tempImage->name, PATHINFO_EXTENSION);
                    $slugName = Str::slug($category->category_name);
                    $newImageName = $category->id . '-' . $slugName . '.' . $ext;
                    $sourcePath = public_path('/temp/' . $tempImage->name);
                    $destinationPath = public_path('/uploads/category/' . $newImageName);
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($sourcePath);
                    $image->cover(300, 300);
                    $image->save($destinationPath, quality: 80);
                    $category->image = $newImageName;
                    $category->save();

                    File::delete($sourcePath);
                }
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
            $category->menu_order = $request->menu_order;
            $category->save();

            $oldImage = $category->image;

            // Save image here
            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);

                if ($tempImage) {
                    $manager = new ImageManager(new Driver());
                    $ext = pathinfo($tempImage->name, PATHINFO_EXTENSION);
                    $newImageName = $category->id . '-' .
                        Str::slug($category->category_name) . '.' . $ext;

                    $sourcePath = public_path('/temp/' . $tempImage->name);
                    $destinationPath = public_path('/uploads/category/' . $newImageName);

                    // Read image
                    $image = $manager->read($sourcePath);
                    $image->cover(300, 300);
                    $image->save($destinationPath, quality: 80);

                    // Update database
                    $oldImage = $category->image;
                    $category->image = $newImageName;
                    $category->save();

                    // Delete old image
                    if ($oldImage) {
                        File::delete(public_path('/uploads/category/' . $oldImage));
                    }

                    // Delete temp image
                    File::delete($sourcePath);
                }
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

    public function subCategory_update($subCategoryId, Request $request){
        $subCategory = SubCategory::find($subCategoryId);

        if(empty($subCategory)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $validator = Validator::make($request->all(), [
            // 'sub_category_name' => 'required',
            // 'sub_category_slug' => 'required|unique:sub_categories,sub_category_slug,'.$subCategory->id.',id',
            // 'category' => 'required',
            // 'status' => 'required',
        ]);

        if ($validator->passes()) {
            $subCategory->sub_category_name = $request->sub_category_name;
            $subCategory->sub_category_slug = $request->sub_category_slug;
            $subCategory->status = $request->status;            
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

    public function subSubCategory_update($subSubCategoryId, Request $request){
        $sub2Category = SubSubCategory::find($subSubCategoryId);

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

    public function subCategory_store(Request $request){
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

    public function subSubCategory_store(Request $request){
        $validator = Validator::make($request->all(), [
            'sub_sub_category_name' => 'required',
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
            $sub_sub_category = new SubSubCategory();
            $sub_sub_category->category_id = $request->category_id;
            $sub_sub_category->sub_category_id = $request->sub_category_id;
            $sub_sub_category->sub_sub_category_name = $request->sub_sub_category_name;
            $sub_sub_category->sub_sub_category_slug = $request->sub_sub_category_slug;            
            $sub_sub_category->save();

            $request->session()->flash('success', 'Sub Sub Category added successfully');

            return response([
                'status' => true,
                'message' => 'Sub Sub Category added successfully',
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

    public function subCategory_destroy ($id, Request $request){
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

    public function subSubCategory_destroy($id, Request $request){
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

    
}
