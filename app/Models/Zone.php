<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Traits\HasSpatial;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\ZoneScope;

class Zone extends Model
{
    use HasFactory;
    use HasSpatial;

    protected $fillable = [
        'coordinates'
    ];

    protected $casts = [
        'status' => 'integer',
        'cash_on_delivery' => 'boolean',
        'digital_payment' => 'boolean',
        'coordinates' => Polygon::class,
    ];

    public function translations()
    {
        return $this->morphMany(Translation::class, 'translationable');
    }

    public function getNameAttribute($value){
        if (count($this->translations) > 0) {
            foreach ($this->translations as $translation) {
                if ($translation['key'] == 'name') {
                    return $translation['value'];
                }
            }
        }

        return $value;
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function deliverymen()
    {
        return $this->hasMany(DeliveryMan::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Store::class);
    }


    public function campaigns()
    {
        return $this->hasManyThrough(Campaigns::class, Store::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function scopeContains($query,$abc){
        return $query->whereRaw("ST_Distance_Sphere(coordinates, POINT({$abc}))");
    }

    protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);

        static::addGlobalScope('translate', function (Builder $builder) {
            $builder->with(['translations' => function($query){
                return $query->where('locale', app()->getLocale());
            }]);
        });
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class)->withPivot(['per_km_shipping_charge','minimum_shipping_charge','maximum_shipping_charge','maximum_cod_order_amount'])->using('App\Models\ModuleZone');
    }

    public static function query()
    {
        return parent::query();
    }
}
