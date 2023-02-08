<?php

namespace App\Models;

use App\Traits\Paging;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory, Paging;

    protected $fillable = ['name','description','enable'];

    public function images(){
        return $this->hasMany(ImageProduct::class)
                    ->join(DB::raw('(select id, name, file from images) images'),'images.id','image_products.image_id');
    }

    public function categories(){
        return $this->hasMany(CategoryProduct::class)
                    ->join(DB::raw('(select id, name from categories) categories'),'categories.id','category_products.category_id');
    }
}
