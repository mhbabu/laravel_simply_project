<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    protected $guarded = [];

    protected $table = 'products';


    public static function getProductList()
    {
        return Product::leftJoin('subcategories', 'subcategories.id','=', 'products.subcategory_id')
            ->leftJoin('categories', 'categories.id','=', 'subcategories.category_id')
           ->latest();
    }

    public function subcategories(){
        return $this->belongsToMany(Subcategory::class);
    }
}
