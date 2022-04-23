<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model
{
    protected $table = 'rooms';
    protected $fillable = ['name'];
}
