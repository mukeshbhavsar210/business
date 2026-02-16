<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Sub2CategoryController extends Controller {
    public function index(Request $request) {
        $sub2Categories = SubSubCategory::select(
                'sub_sub_categories.*',
                'sub_categories.name as subCategoryName',
                'categories.name as categoryName'
            )
            ->leftJoin('sub_categories', 'sub_categories.id', '=', 'sub_sub_categories.sub_category_id')
            ->leftJoin('categories', 'categories.id', '=', 'sub_sub_categories.category_id')
            ->latest('sub_sub_categories.id');

        if ($request->filled('keyword')) {

            $keyword = $request->keyword;

            $sub2Categories->where(function ($query) use ($keyword) {
                $query->where('sub_sub_categories.name', 'like', "%$keyword%")
                    ->orWhere('sub_categories.name', 'like', "%$keyword%")
                    ->orWhere('categories.name', 'like', "%$keyword%");
            });
        }

        $sub2Categories = $sub2Categories->paginate(10);

        return view('admin.categories.sub2_category.list', compact('sub2Categories'));
    }



    public function create(){
        $categories = Category::orderBy('name','ASC')->get();
        $subCategories = subCategory::orderBy('name', 'ASC')->get();

        $data['subCategories'] = $subCategories;
        $data['categories'] = $categories;

        return view("admin.categories.sub2_category.create", $data);
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
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
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $sub2Category = new SubSubCategory();
            $sub2Category->category_id = $request->category;
            $sub2Category->sub_category_id = $request->sub_category_id;
            $sub2Category->name = $request->name;
            $sub2Category->slug = $request->slug;
            $sub2Category->status = $request->status;            
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

    public function edit($id, Request $request) {
        $sub2Category = SubSubCategory::findOrFail($id);

        $categories = Category::orderBy('name','ASC')->get();

        // Load subcategories of selected category
        $subCategories = SubCategory::where('category_id', $sub2Category->category_id)->get();

        return view("admin.categories.sub2_category.edit", compact(
            'sub2Category',
            'categories',
            'subCategories'
        ));
    }

    public function edit2($id, Request $request) {
        $sub2Category = SubSubCategory::find($id);

        if (empty($sub2Category)) {
            $request->session()->flash('error', 'Record not found');
            return redirect()->route('sub2-categories.index');
        }

        $categories = Category::orderBy('name', 'ASC')->get();

        // Load subcategories of selected category
        $subCategories = SubCategory::where('category_id', $sub2Category->category_id)
                            ->orderBy('name', 'ASC')
                            ->get();

        return view("admin.categories.sub2_category.edit", compact(
            'categories',
            'subCategories',
            'sub2Category'
        ));
    }


    public function update($id, Request $request){

        $sub2Category = SubSubCategory::find($id);

        if(empty($sub2Category)){
            $request->session()->flash('error','Record not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            //'slug' => 'required|unique:sub_sub_categories,slug,'.$sub2Category->id.',id',
            'category' => 'required',
            'sub_category' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $sub2Category->category_id = $request->category_id;
            $sub2Category->sub_category_id = $request->sub_category_id;
            $sub2Category->name = $request->name;
            $sub2Category->slug = $request->slug;
            $sub2Category->status = $request->status;            
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
    

    public function destroy($id, Request $request){
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
