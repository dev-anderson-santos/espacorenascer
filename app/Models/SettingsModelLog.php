<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SettingsModelLog extends Model
{
    protected $table = 'settings_log';
    // Configurações para UUID na PK
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id',
        'settings_id',
        'valor_fixo',
        'valor_avulso',
        'dia_fechamento',
        'data_vencimento'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'settings_id' => 'string' // Assumindo que SettingsModel também usará UUID
    ];

    /**
     * Para Laravel 7 - datas que devem ser tratadas como Carbon
     *
     * @var array
     */
    protected $dates = [
        'data_vencimento',
        'created_at',
        'updated_at'
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
