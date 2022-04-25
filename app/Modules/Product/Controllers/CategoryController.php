<?php

namespace App\Modules\Product\Controllers;

use App\DataTables\Product\CategoryListDataTable;
use App\Modules\Product\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryListDataTable $dataTable){
        return $dataTable->render("Product::category.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view("Product::category.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name'         => 'required|unique:categories',
                'status'       => 'required'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validation->errors()
                ]);
            }


            $category = new Category();
            $category->name = $request->input('name');
            $category->status = $request->input('status');
            $category->created_at = Carbon::now();
            $category->save();

            return response()->json([
                'success' => true,
                'status'  => 'Category created successfully.',
                'link' => route('admin.product.categories.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'status' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $categoryId
     * @return \Illuminate\Http\Response
     */
    public function show($categoryId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data['category'] = $category;
        return view("Product::category.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validation = Validator::make($request->all(), [
                'name'         => 'unique:categories,name,'.$category->id,
                'status'       => 'required'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validation->errors()
                ]);
            }

            $category = $category;
            $category->name = $request->input('name');
            $category->updated_at = Carbon::now();
            $category->status = $request->input('status');
            $category->save();

            return response()->json([
                'success' => true,
                'status' => 'Category updated successfully.',
                'link' => route('admin.product.categories.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'status' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([]);
    }
}
