<?php

namespace App\Models;

use App\Models\City;
use App\Models\StorePhoto;
use Illuminate\Support\Str;
use App\Models\StoreService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Store extends Model
{
    protected $table = 'stores';

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'is_open',
        'is_full',
        'address',
        'phone_number',
        'cs_name',
        'city_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function storeServices(): HasMany
    {
        return $this->hasMany(StoreService::class, 'store_id');
    }

    public function storePhotos(): HasMany
    {
        return $this->hasMany(StorePhoto::class, 'store_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
