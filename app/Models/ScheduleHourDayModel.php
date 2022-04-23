<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleHourDayModel extends Model
{
    protected $table = 'schedules_hours_days';
    protected $fillable = ['schedule_id', 'hour_id', 'days_of_week_id'];

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
        return $this->belongsTo(DaysOfWeekModel::class, 'days_of_week_id');
    }
}
