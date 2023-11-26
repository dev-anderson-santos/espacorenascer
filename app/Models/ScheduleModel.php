<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduleModel extends Model
{
    use SoftDeletes;

    protected $table = 'schedules';
    protected $primaryKey = 'id';
    public $dates = ['deleted_at'];
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
