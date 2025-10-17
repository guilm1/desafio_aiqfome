<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteHasProdutosFavoritos extends Model
{
    protected $table = 'cliente_has_produtos_favoritos';

    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'cliente_id',
        'produto_externo_id',
    ];
}
