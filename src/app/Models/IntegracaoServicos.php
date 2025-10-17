<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IntegracaoServicos extends Model
{
    protected $table = 'integracao_servicos';
    protected $fillable = ['name', 'sigla'];

    public function camposIntegracao(): HasMany
    {
        return $this->hasMany(IntegracaoServicosHasCampos::class, 'integracao_servicos_id');
    }
}
