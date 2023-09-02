<?php

namespace Ecommerce\Product\Models;

use Ecommerce\Category\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array
     */
    protected $guarded=[];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories(){
        return $this->belongsTo(Category::class,'category_id');
    }

}
