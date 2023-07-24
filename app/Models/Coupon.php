<?php

namespace App\Models;

use App\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $casts = [
        'min_purchase' => 'float',
        'max_discount' => 'float',
        'discount' => 'float',
        'limit'=>'integer',
        'store_id'=>'integer',
        // 'customer_id'=>'integer',
        'status'=>'integer',
        'id'=>'integer',
        'total_uses'=>'integer',
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getTitleAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                // dd($translation['key']);
                if ($translation['key'] == 'title') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }
    
    public function scopeModule($query, $module_id)
    {
        return $query->where('module_id', $module_id);
    }
    
    protected static function booted()
    {
        // if(auth('vendor')->check())
        // {
        //     static::addGlobalScope(new StoreScope);
        // } 
        static::addGlobalScope('translate', function (\Illuminate\Database\Eloquent\Builder $builder) {
            $builder->with(['translations' => function ($query) {
                return $query->where('locale', app()->getLocale());
            }]);
        });
    }
}
