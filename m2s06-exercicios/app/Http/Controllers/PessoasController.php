<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;

class PessoasController extends Controller
{
    public function index()
    {
        try {
            $pessoas = Pessoa::all();
            $qtdPessoas = $pessoas->count();
            $message = $qtdPessoas . " " . ($qtdPessoas === 1 ? "pessoa encontrada com sucesso." : "pessoas encontradas com sucesso.");
            return $this->response($message, $pessoas, true, 200);
        } catch (\Exception $exception) {
            return $this->response($exception->getMessage(), null, false, 500);
        }
    }
}
