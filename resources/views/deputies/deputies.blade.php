@extends('layouts.app')

@section('content')
    <h2 class="h4 mb-3">Deputados</h2>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label">UF</label>
            <select name="uf" class="form-select">
                <option value="">Todos</option>
                @foreach($ufs as $ufOption)
                    <option value="{{ $ufOption }}" {{ $uf == $ufOption ? 'selected' : '' }}>
                        {{ $ufOption }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Partido</label>
            <select name="partido" class="form-select">
                <option value="">Todos</option>
                @foreach($parties as $partyOption)
                    <option value="{{ $partyOption }}" {{ $party == $partyOption ? 'selected' : '' }}>
                        {{ $partyOption }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    {{-- Cards --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($deputies as $dep)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img style="height: 250px; object-fit: cover;" src="https://www.camara.leg.br/internet/deputado/bandep/{{ $dep->id }}.jpg"
                         class="card-img-top img-deputado"
                         alt="Foto de {{ $dep->nome }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $dep->nome }}</h5>
                        <p class="card-text mb-1"><strong>Partido:</strong> {{ $dep->sigla_partido }}</p>
                        <p class="card-text"><strong>UF:</strong> {{ $dep->sigla_uf }}</p>
                        <a href="{{ route('deputy', $dep->id) }}" class="btn btn-outline-primary btn-sm mt-2">Ver gastos</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

