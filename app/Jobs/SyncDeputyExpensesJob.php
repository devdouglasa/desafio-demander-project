<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Models\Expense;
use App\Models\Deputie;

class SyncDeputyExpensesJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $timeout = 2400;

    public $failOnTimeout = false;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $responseDeputies = Http::get('https://dadosabertos.camara.leg.br/api/v2/deputados')['dados'];


        foreach ($responseDeputies as $dep) {
            $depInfoDetail = Http::get('https://dadosabertos.camara.leg.br/api/v2/deputados/' . $dep['id'])['dados'];

            // Aqui você pode salvar no banco, ex:
            Deputie::updateOrCreate(
                ['id' => $dep['id']],
                [
                    'nome' => $dep['nome'],
                    'sigla_uf' => $dep['siglaUf'],
                    'sigla_partido' => $dep['siglaPartido'],
                    'url_foto' => $dep['urlFoto'],
                    'email' => $dep['email'],
                    'nome_civil' => $depInfoDetail['nomeCivil'] ?? null,
                    'gabinete_predio' => $depInfoDetail['ultimoStatus']['gabinete']['predio'] ?? null,
                    'gabinete_sala' => $depInfoDetail['ultimoStatus']['gabinete']['sala'] ?? null,
                    'gabinete_telefone' => $depInfoDetail['ultimoStatus']['gabinete']['telefone'] ?? null,
                    'gabinete_email' => $depInfoDetail['ultimoStatus']['gabinete']['email'] ?? null,
                ]
            );

            $responseExpenses = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/" . $dep['id'] . "/despesas")['dados'];

            foreach ($responseExpenses as $expense) {
                Expense::updateOrCreate(
                    ['deputado_id' => $dep['id']],
                    [
                        'ano' => $expense['ano'],
                        'mes' => $expense['mes'],
                        'tipo_despesa' => $expense['tipoDespesa'],
                        'fornecedor' => $expense['nomeFornecedor'],
                        'cnpj_cpf' => $expense['cnpjCpfFornecedor'],
                        'valor_documento' => $expense['valorDocumento'],
                        'valor_glosa' => $expense['valorGlosa'],
                        'valor_liquido' => $expense['valorLiquido'],
                        'data_documento' => $expense['dataDocumento'],
                        'url_documento' => $expense['urlDocumento'],
                    ]
                );
            }
        }
    }
}
