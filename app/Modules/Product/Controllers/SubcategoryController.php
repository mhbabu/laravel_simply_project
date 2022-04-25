<?php

namespace App\Modules\Product\Controllers;

use App\DataTables\Product\SubcategoryListDataTable;
use App\Modules\Product\Models\Category;
use App\Modules\Product\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubcategoryListDataTable $dataTable){
        return $dataTable->render("Product::subcategory.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $data['categories'] = Category::where('status','Active')->pluck('name','id');
        return view("Product::subcategory.create", $data);
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
                'title'       => ['required', Rule::unique('subcategories')
                    ->where(function ($query) use ($request) {
                        $query->where('category_id', $request->input('category_id'));
                    })],
                'category_id' => 'required',
                'description' => 'required|string|min:30',
                'status'      => 'required|in:Active,Inactive',
            ],[
                'category_id.required' => 'The category field is required'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validation->errors()
                ]);
            }

            $subcategory = new Subcategory();
            $subcategory->category_id = $request->input('category_id');
            $subcategory->title = $request->input('title');
            $subcategory->description = $request->input('description');
            $subcategory->status = $request->input('status');
            $subcategory->save();

            return response()->json([
                'success' => true,
                'status'  => 'Subcategory created successfully.',
                'link' => route('admin.product.subcategories.index')
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
     * @param int $subcategoryId
     * @return \Illuminate\Http\Response
     */
    public function show($subcategoryId)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        $data['subcategory'] = $subcategory;
        $data['categories'] = Category::where('status','Active')->pluck('name','id');
        return view("Product::subcategory.edit", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        try {
            $validation = Validator::make($request->all(), [
                'title'       => ['required', Rule::unique('subcategories')->ignore($subcategory->id)
                    ->where(function ($query) use ($request) {
                        $query->where(['category_id' => $request->input('category_id')]);
                    })],
                'category_id' => 'required',
                'description' => 'required|string|min:30',
                'status'      => 'required|in:Active,Inactive',
            ],[
                'category_id.required' => 'The category field is required'
            ]);

            if ($validation->fails()) {
                return response()->json([
                    'success' => false,
                    'error' => $validation->errors()
                ]);
            }
            $subcategory->update([
               'category_id' =>  $request->input('category_id'),
               'title'       =>  $request->input('title'),
               'description' =>  $request->input('description'),
               'status'      =>  $request->input('status')
            ]);

            return response()->json([
                'success' => true,
                'status' => 'Subcategory updated successfully.',
                'link' => route('admin.product.subcategories.index')
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
     * @param int $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return response()->json([]);
    }

    public function subcategoriesByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        $subcategories = Subcategory::where('category_id', $categoryId)
            ->where('status', 'Active')
            ->orderBy('title', 'ASC')
            ->pluck('title', 'id');
        $data = ['responseCode' => 1, 'data' => $subcategories];
        return response()->json($data);
    }
}
