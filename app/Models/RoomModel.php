<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomModel extends Model
{
    use SoftDeletes;

    protected $table = 'rooms';
    public $dates = ['deleted_at'];
    protected $fillable = ['name'];
}
