<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScheduleHourDayModel extends Model
{
    protected $table = 'schedules_hours_days';
    // Configurações para UUID na PK
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = ['schedule_id', 'hour_id', 'days_of_week_id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'schedule_id' => 'string', // FK para ScheduleModel (UUID)
        'hour_id' => 'string', // Assumindo que HourModel usará UUID
        'days_of_week_id' => 'string'
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

    public function schedule()
    {
        return $this->belongsTo(ScheduleModel::class, 'schedule_id');
    }

    public function hour()
    {
        return $this->belongsTo(HourModel::class, 'hour_id');
    }

    public function daysOfWeek()
    {
        return $this->belongsTo(DayOfWeekModel::class, 'days_of_week_id');
    }
}
