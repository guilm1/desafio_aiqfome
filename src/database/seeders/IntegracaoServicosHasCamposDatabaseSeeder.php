<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntegracaoServicosHasCampos;
use App\Models\IntegracaoServicos;

class IntegracaoServicosHasCamposDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->integrarApiProdutoExterno('APE');
    }

    private function integrarApiProdutoExterno(string $sigla)
    {
        $integracaoServicos = IntegracaoServicos::where('sigla', $sigla)->first();
        if ($integracaoServicos) {
            $baseUrl = env('URL_BASE_API_PRODUTO_EXTERNO');
            IntegracaoServicosHasCampos::updateOrCreate(
                [
                    'integracao_servicos_id' => $integracaoServicos->id,
                    'sigla' => 'URL',
                    'valor' => $baseUrl,
                ]
            );
        }
    }
}
