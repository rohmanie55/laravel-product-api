<?php

namespace App\Models;

use App\Traits\Paging;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Paging;

    protected $table = 'categories';

    protected $fillable = ['name','enable'];
}
