<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsModelLog extends Model
{
    protected $table = 'settings_log';
    protected $fillable = [
        'user_id',
        'settings_id',
        'valor_fixo',
        'valor_avulso',
        'hora_fechamento',
        'dia_fechamento',
        'data_vencimento',
    ];
}
