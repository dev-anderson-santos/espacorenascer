<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DayOfWeekModel extends Model
{
    protected $table = 'daysofweeks';
    protected $fillable = ['date'];
}
