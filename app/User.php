<?php

namespace App;

use App\Models\AddressModel;
use App\Models\UserHasAddressesModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'phone',
        'email_verified_at',
        'cpf',
        'inscricao_crp_crm',
        'birth_date',
        'academic_formations',
        'syndromes_special_situations_experience',
        'age_range_service',
        'approach_lines',
        'is_admin',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasAddress(): HasOne
    {
        return $this->hasOne(UserHasAddressesModel::class, 'user_id', 'id');
    }
}
