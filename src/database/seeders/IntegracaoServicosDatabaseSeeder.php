<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IntegracaoServicos;

class IntegracaoServicosDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        IntegracaoServicos::updateOrCreate(
            ['sigla' => 'APE'],
            [
                'name'     => 'API de Produtos Externos',
                'sigla'    => 'APE',
            ]
        );
    }
}
