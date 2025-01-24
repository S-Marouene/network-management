<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Points extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'points';
    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'x',
        'y',
        'device_id',
        'network_id',
        'user_id',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'x' => 'decimal:2',
        'y' => 'decimal:2',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include points for a specific network ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $networkId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForNetwork($query, $networkId)
    {
        return $query->where('network_id', $networkId);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
