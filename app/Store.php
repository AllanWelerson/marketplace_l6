<?php

namespace App;

use App\Notifications\StoreReceiveNewOrder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\Slug;

class Store extends Model
{
//    use HasSlug;
    use Slug;

    protected $fillable = ['name','description','slug','phone','mobile_phone','logo'];

    /**
     * Get the options for generating the slug.
     */
//    public function getSlugOptions() : SlugOptions
//    {
//        return SlugOptions::create()
//            ->generateSlugsFrom('name')
//            ->saveSlugsTo('slug');
//    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->belongsToMany(UserOrder::class, 'order_store','store_id','order_id');
    }

    public function notifyStoreOwners(array $storesId = [])
    {
        $stores = \App\Store::whereIn('id',$storesId)->get();

        $stores->map(function($store){
            return $store->user;
        })->each->notify(new StoreReceiveNewOrder());
    }

}
