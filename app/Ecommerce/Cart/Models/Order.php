<?php

namespace Ecommerce\Cart\Models;

use App\Models\User;
use Ecommerce\Category\Models\Category;
use Ecommerce\Customer\Models\Customer;
use Ecommerce\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory;
    use Notifiable;

    /**
     * @var array
     */
    protected $guarded=[];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories(){
        return $this->belongsTo(Category::class,'categorie_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customers(){
        return $this->belongsTo(Customer::class,'costomer_id');
    }
}
