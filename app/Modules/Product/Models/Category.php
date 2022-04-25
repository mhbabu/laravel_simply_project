<?php

namespace App\Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $guarded = [];

    protected $table = 'categories';

    public static function getCategoryList(){
        return Category::latest();
    }
}
