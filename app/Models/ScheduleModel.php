<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ScheduleModel extends Model
{
    protected $table = 'schedules';
    protected $fillable = [
        'user_id', 
        'room_id', 
        'created_by',
        'hour_id', 
        'date',
        'status',
        'tipo',
        'faturado',
        'finalizado_em',
        'data_nao_faturada_id',
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
