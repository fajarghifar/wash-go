<?php

namespace App\Models;

use App\Models\Store;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'booking_transactions';

    protected $fillable = [
        'name',
        'trx_id',
        'proof',
        'phone_number',
        'is_paid',
        'total_amount',
        'store_id',
        'service_id',
        'started_at',
        'time_at',
    ];

    protected $casts = [
        'started_at' => 'date'
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = 'CC';
        do {
            $randomString = $prefix . mt_rand(1000, 9999);
        } while (self::where('trx_id', $randomString)->exists());

        return $randomString;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->trx_id = 'TRX-' . now()->format('YmdHis') . '-' . Str::random(6);
        });
    }

    public function service_details(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function store_details(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
