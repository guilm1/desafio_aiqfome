<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IntegracaoServicosHasCampos extends Model
{
    protected $table = 'integracao_servicos_has_campos';
    protected $fillable = ['integracao_servicos_id', 'sigla', 'valor'];

    public function integracaoServicos(): BelongsTo
    {
        return $this->belongsTo(IntegracaoServicos::class, 'integracao_servicos_id');
    }
}
