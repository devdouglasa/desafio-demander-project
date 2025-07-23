<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deputie extends Model
{
    protected $table = 'deputies';
    protected $fillable = [
        'id',
        'nome',
        'sigla_uf',
        'sigla_partido',
        'url_foto',
        'email',
        'nome_civil',
        'gabinete_predio',
        'gabinete_sala',
        'gabinete_telefone',
        'gabinete_email',
    ];

    public $incrementing = false;
    protected $keyType = 'int';

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
