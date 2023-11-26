<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataNaoFaturadaModel extends Model
{
    protected $table = 'data_nao_faturada';
    protected $primaryKey = 'id';
    protected $fillable = ['data'];
}
