<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeModel extends Model
{
    protected $table = 'charge';
    protected $primarykey = 'id';
    protected $fillable = [
        'amount',
        'payday',
        'status',
        'user_id',
        'created_by',
        'updated_by',
        'reference_month',
        'reference_year',
    ];
}
