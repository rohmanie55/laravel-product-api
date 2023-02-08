<?php
namespace App\Traits;

use Illuminate\Support\Str;

trait Paging{

   /**
     * Scope a query to create pagination.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopePaging($query, $perpage=10)
    {
        $page = (request()->page>1) ? (request()->page * $perpage) - $perpage : 0;

        return [
            'total'=>$query->count(),
            'data' =>$query->offset($page)->limit($perpage)->get()
        ];
    }
}