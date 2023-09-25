<?php
namespace App\Services;

use App\Helpers\GerarRelatorio;

class ReportsService
{
    public static function gerarRelatorioCobranca($dados)
    {

        $nomeArquivo = 'EspacoJuntos_relatorio_cobranca_mensal'.'-'.date('dmYhis');
        $clientes = [
            'clientes' => array_values($dados['clientes']->toArray()),
            'mes' => $dados['_month'],
            'ano' => $dados['_year'],
            'titulo' => 'Relatório de Cobranca Mensal'
        ];

        return GerarRelatorio::renderizar(2, 'pdf', $clientes, $nomeArquivo);
    }
}