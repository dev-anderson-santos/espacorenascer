<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserHasAddressesModel extends Model
{
    protected $table = 'users_has_addresses';
    
    // Configurações para UUID na PK
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = ['user_id', 'address_id'];
    
    public $with = ['address'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'address_id' => 'string' // Assumindo que AddressModel também usará UUID
    ];

    /**
     * Gera automaticamente um UUID quando o modelo é criado
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address()
    {
        return $this->belongsTo(AddressModel::class, 'address_id');
    }
}
