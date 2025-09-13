<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DataNaoFaturadaModel extends Model
{
    protected $table = 'data_nao_faturada';
    
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = ['data'];

    protected $casts = [
        'id' => 'string'
    ];

    protected $dates = [
        'data',
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
