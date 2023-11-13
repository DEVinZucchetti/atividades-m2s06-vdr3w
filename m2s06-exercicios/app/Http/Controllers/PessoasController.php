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

    public function update($id, Request $request)
    {
        $dataValidada = $request->validate([
            'name' => 'required|min:3|max:150',
            'cpf' => 'nullable|min:11|max:20',
            'contact' => 'nullable|max:20',
        ]);

        try {
            $pessoa = Pessoa::find($id);

            if (empty($pessoa)) {
                return $this->response('Pessoa não encontrada', null, false, 404);
            }

            $pessoa->update($request->all());

            $message = "{$pessoa->name} atualizado(a) com sucesso!";
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

    public function destroy($id)
    {
        try {
            $pessoa = Pessoa::find($id);
            if ($pessoa) {
                $pessoa->delete();
                return response()->json([
                    'success' => true,
                    'data' => $pessoa,
                    'message' => 'Pessoa deletada com sucesso.',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => 'Pessoa não encontrada.',
                ], 400);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => 'Erro ao excluir a pessoa: ' . $exception->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $pessoa = Pessoa::find($id);

            if ($pessoa) {
                return response()->json([
                    'success' => true,
                    'data' => $pessoa,
                    'message' => "Pessoa encontrada com sucesso.",
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'data' => null,
                    'message' => "Pessoa não encontrada no banco de dados",
                ], 404);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => "Erro no servidor: " . $exception->getMessage(),
            ], 500);
        }
    }
}
