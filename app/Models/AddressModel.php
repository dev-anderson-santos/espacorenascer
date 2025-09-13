<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AddressModel extends Model
{
    protected $table = 'addresses';
    
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $fillable = [
        'zipcode',
        'street',
        'complement',
        'number',
        'district',
        'city',
        'state'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    public function roomHasAddresses()
    {
        return $this->hasMany(RoomHasAddressesModel::class, 'address_id');
    }
}
