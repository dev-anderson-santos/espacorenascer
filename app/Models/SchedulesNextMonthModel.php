<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SchedulesNextMonthModel extends Model
{
    protected $table = 'schedule_next_month';
    // Configurações para UUID na PK
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id', 
        'room_id', 
        'created_by',
        'hour_id', 
        'date',
        'status',
        'tipo',
        'data_nao_faturada_id',
        'is_mirrored',
        'valor'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'room_id' => 'string', // Assumindo que RoomModel também usará UUID
        'created_by' => 'string', // FK para User
        'hour_id' => 'string', // Assumindo que HourModel também usará UUID
        'data_nao_faturada_id' => 'string' // Assumindo que o modelo relacionado usará UUID
    ];

    /**
     * Para Laravel 7 - datas que devem ser tratadas como Carbon
     *
     * @var array
     */
    protected $dates = [
        'date',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(RoomModel::class, 'room_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function hour()
    {
        return $this->belongsTo(HourModel::class, 'hour_id');
    }
}
