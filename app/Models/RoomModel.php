<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomModel extends Model
{
    use SoftDeletes;

    protected $table = 'rooms';
    
    // Configurações para UUID na PK
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    // Para Laravel 7 - datas que devem ser tratadas como Carbon
    public $dates = ['deleted_at', 'created_at', 'updated_at'];
    
    protected $fillable = ['name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * Gera automaticamente um UUID quando o modelo é criado
     */
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
