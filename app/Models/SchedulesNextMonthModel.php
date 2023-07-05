<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchedulesNextMonthModel extends Model
{
    protected $table = 'schedule_next_month';
    protected $primaryKey = 'id';
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
