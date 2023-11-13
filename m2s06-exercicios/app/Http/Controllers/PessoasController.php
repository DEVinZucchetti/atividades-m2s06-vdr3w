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

    public function store(Request $request)
    {
        $dataValidada = $request->validate([
            'name' => 'required|min:3|max:150',
            'cpf' => 'nullable|min:11|max:20',
            'contact' => 'nullable|max:20',
        ]);

        try {
            $pessoa = Pessoa::create($dataValidada);
            $message = "{$pessoa->name} cadastrado(a) com sucesso!";
            return response()->json([
                'success' => true,
                'data' => $pessoa,
                'message' => $message,
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => "Erro ao cadastrar a pessoa: {$exception->getMessage()}",
            ], 500);
        }
    }
}
