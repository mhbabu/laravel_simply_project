<?php

namespace App\Modules\Product\Controllers;

use App\DataTables\Product\ProductDataTable;
use App\DataTables\Product\ProductFilterDataTable;
use App\Modules\Product\Models\Category;
use App\Modules\Product\Models\Product;
use App\Modules\Product\Models\Subcategory;
use App\Modules\Proposal\Models\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductDataTable $dataTable)
    {
        $data['categories'] = Category::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id');
        return $dataTable->render("Product::product.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = Category::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id');
        $data['subCategories'] = Subcategory::where('title', 1)->orderBy('title', 'ASC')->pluck('title', 'id');
        return view("Product::product.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required', Rule::unique('products')->where(function ($query) use ($request) {
                $query->where([
                'subcategory_id' => $request->input('subcategory_id')
                ]);
            })],
            'subcategory_id' => 'required',
            'price' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,jpg,png',
            'status' => 'required|in:Active,Inactive',
        ],[
            'subcategory_id.required' => 'The subcategory field is required.',
            'thumbnail.required' => 'The thumbnail image is required'
        ]);

        $product = new Product();
        $product->subcategory_id = $request->input('subcategory_id');
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->status = $request->input('status');

        $path = 'uploads/product_thumbnail/';
        if($request->hasFile('thumbnail')){
            $_productThumbnail = $request->file('thumbnail');

            if(!file_exists($path))
                mkdir($path, 0777, true);

            $productThumbnail = trim(sprintf('%s', uniqid('ProductThumbnail_', true))) . '.' . $_productThumbnail->getClientOriginalExtension();
            Image::make($_productThumbnail->getRealPath())->resize(300,250)->save($path . '/' . $productThumbnail);
            $product->thumbnail = $productThumbnail;
        }

        $product->save();

        return redirect(route('admin.products.index'))->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $productId
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProductFilterDataTable $dataTable)
    {
        $data['params'] = $request->all();
        $data['categories'] = Category::where('status', 1)->orderBy('name', 'ASC')->pluck('name', 'id');
        return $dataTable->render("Product::product.index", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $productId
     * @return \Illuminate\Http\Response
     */
    public function edit($productId)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $productId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $productId)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([]);
    }
}
