<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Blog extends Model
{
    protected $guarded = [];

    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
