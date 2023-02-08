<?php

namespace App\Models;

use App\Traits\Paging;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory, Paging;

    protected $fillable = ['name','file','enable'];
}
