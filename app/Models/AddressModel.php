<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
    protected $table = 'addresses';
    protected $fillable = [
        'zipcode',
        'street',
        'complement',
        'number',
        'district',
        'city',
        'state'
    ];

    public function roomHasAddresses()
    {
        return $this->hasMany(RoomHasAddressesModel::class, 'address_id');
    }
}
