<?php

namespace App\Http\Controllers;

use App\Jobs\SyncDeputyExpensesJob;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Models\Deputie;

class DeputyController extends Controller
{
    function index(Request $request)
    {
        $uf = $request['uf'];
        $party = $request['party'];

        $validatedName = $request->validate([
            'name' => 'string|max:100'
        ]);


        $query = Deputie::query();

        if ($uf)
        {
            $query->where('sigla_uf', $uf);
        }

        if ($party)
        {
            $query->where('sigla_partido', $party);
        }

        if($request->filled('name'))
        {
            $query->where('nome', 'like', '%' . $validatedName['name'] . '%');
        }

        $deputies = $query->paginate(10);

        $ufs = Deputie::select('sigla_uf')->distinct()->orderBy('sigla_uf')->pluck('sigla_uf');

        $parties = Deputie::select('sigla_partido')->distinct()->orderBy('sigla_partido')->pluck('sigla_partido');

        return view('deputies.deputies', compact('deputies', 'uf', 'party', 'ufs', 'parties'));
    }

    function show(int $id)
    {
        $year = request('year') ?? date('Y');
        $month = request('month');


        $deputy = Deputie::findOrFail($id);

        $query = Expense::where('deputado_id', $id)->where('ano', $year);

        if ($month) {
            $query->where('mes', $month);
        }

        $expenses = $query->orderBy('data_documento')->get();


        $totalExpenses = $expenses->sum('valor_documento');


        $expensesForType = $expenses->orderBy('tipo_despesa')->map(function ($items) {
            return $items->sum('valor_documento');
        });

        return view('deputies.deputy', compact('deputy', 'expenses', 'totalExpenses', 'expensesForType'));
    }
}
