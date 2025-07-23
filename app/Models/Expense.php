<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

    protected $fillable = [
        'deputado_id',
        'ano',
        'mes',
        'tipo_despesa',
        'fornecedor',
        'cnpj_cpf',
        'valor_documento',
        'valor_glosa',
        'valor_liquido',
        'data_documento',
        'url_documento',
    ];

    protected $casts = [
        'data_documento' => 'date',
    ];

    public function deputies()
    {
        return $this->belongsTo(Deputie::class);
    }

}
