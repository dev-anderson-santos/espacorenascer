<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomHasAddressesModel extends Model
{
    protected $table = 'room_has_addresses';
    protected $fillable = ['room_id', 'address_id'];

    public function room()
    {
        return $this->belongsTo(RoomModel::class, 'room_id');
    }

    public function address()
    {
        return $this->belongsTo(AddressModel::class, 'address_id');
    }
}
