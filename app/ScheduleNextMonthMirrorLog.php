<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScheduleNextMonthMirrorLog extends Model
{
    protected $table = 'schedule_next_month_mirror_log';
    protected $fillable = ['message', 'email'];
}
