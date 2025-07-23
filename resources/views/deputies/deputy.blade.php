@extends('layouts.app')

{{ setlocale(LC_TIME, 'pt_BR.UTF-8') }}

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h1 class="card-title h3">{{ $deputy->nome_civil }}</h1>
            <p class="card-text mb-1">
                <span class="fw-semibold">Partido:</span> {{ $deputy->sigla_partido }}
            </p>
            <p class="card-text">
                <span class="fw-semibold">UF:</span> {{ $deputy->sigla_uf }}
            </p>
        </div>
    </div>

    <h2 class="mb-3">Despesas Recentes</h2>

    <!-- Spending chart -->

    <form class="row g-3 mb-4" method="GET" action="{{ route('deputy', $deputy->id) }}">
        <div class="col-auto">
            <label class="form-label" for="ano">Ano:</label>
            <input class="form-control" type="number" name="year" id="year" value="{{ request('year') ?? date('Y') }}" min="2000" max="{{ date('Y') }}">
        </div>

        <div class="col-auto">
            <label class="form-label" for="month">Mês:</label>
            <select class="form-select" name="month" id="month">
                <option value="">Todos</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="col-auto align-self-end">
            <button class="btn btn-primary" type="submit">Filtrar</button>
        </div>
    </form>


    <div class="card mb-4">
        <div class="card-header">Gastos por tipo</div>
        <div class="card-body">
            <canvas id="graficoGastos"></canvas>
        </div>
    </div>

    <div class="alert alert-info">
        Total gasto: <strong>R$ {{ number_format($totalExpenses, 2, ',', '.') }}</strong>
    </div>

    <!-- end -->

    <h3 class="mb-3 mt-5">Despesas Detalhadas</h3>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Data</th>
                <th>Tipo</th>
                <th>Fornecedor</th>
                <th class="text-end">Valor</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $d)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($d->data_documento)->format('d/m/Y') }}</td>
                    <td>{{ $d->tipo_despesa }}</td>
                    <td>{{ $d->fornecedor }}</td>
                    <td class="text-end">R$ {{ number_format($d->valor_documento, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhuma despesa encontrada para o período.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('graficoGastos').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($expensesForType->keys()) !!},
                datasets: [{
                    label: 'Gastos por tipo',
                    data: {!! json_encode($expensesForType->values()) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => 'R$ ' + value.toLocaleString('pt-BR')
                        }
                    }
                }
            }
        });
    </script>

@endsection