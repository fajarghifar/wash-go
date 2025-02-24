<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StorePhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'store_photos';

    protected $fillable = [
        'store_id',
        'photo',
    ];
}
