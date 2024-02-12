<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagemSalaModel extends Model
{
    protected $table = 'imagem_sala';
    protected $primatyKey = 'id';
    protected $fillable = ['filename', 'description', 'order_image', 'created_by'];
}
