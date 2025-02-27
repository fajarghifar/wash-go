<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\StoreService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'about',
        'photo',
        'icon',
        'duration_in_hour'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    public function storeServices(): HasMany
    {
        return $this->hasMany(StoreService::class, 'store_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(StorePhoto::class, 'store_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
