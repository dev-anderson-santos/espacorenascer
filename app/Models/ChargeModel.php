<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChargeModel extends Model
{
    protected $table = 'charge';
    
    // Corrigido de 'primarykey' para 'primaryKey'
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'amount',
        'payday',
        'status',
        'user_id',
        'created_by',
        'updated_by',
        'reference_month',
        'reference_year'
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'created_by' => 'string',
        'updated_by' => 'string'
    ];

    protected $dates = [
        'payday',
        'created_at',
        'updated_at'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
}
