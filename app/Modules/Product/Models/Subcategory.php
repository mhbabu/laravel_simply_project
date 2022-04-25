<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model {

    protected $guarded = [];

    protected $table = 'subcategories';

    public static function getSubcategoryList(){
        return Subcategory::leftJoin('categories','categories.id','=','subcategories.category_id')
            ->latest();
    }

}
