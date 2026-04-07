<?php

namespace App\Http\Controllers;

use App\Models\ListaMaterial;
use Illuminate\Http\Request;

class ListaMateriaisController extends Controller
{
    public function salvar(Request $request)
    {
        $request->validate([
            'turma' => 'required|in:bercario,infantil,fundamental',
            'arquivo.*' => 'nullable|mimes:pdf|max:5000',
            'nomes_exibicao.*' => 'nullable|string|max:255'
        ]);

        // Busca o registro da turma
        $registro = ListaMaterial::where('turma', $request->turma)->first();

        $arquivos = $registro ? $registro->arquivo ?? [] : [];
        $nomes = $registro ? $registro->nomes_exibicao ?? [] : [];

        // SE enviou novos arquivos
        if ($request->hasFile('arquivo')) {

            foreach ($request->file('arquivo') as $i => $file) {

                $novo = $file->store('pdfs', 'public');
                $arquivos[] = $novo;

                // Nome exibido (se enviado)
                $nomes[] = $request->nomes_exibicao[$i] ?? 'Arquivo';
            }
        }

        // Atualiza ou cria
        if ($registro) {
            $registro->update([
                'arquivo' => $arquivos,
                'nomes_exibicao' => $nomes
            ]);
        } else {
            ListaMaterial::create([
                'turma' => $request->turma,
                'arquivo' => $arquivos,
                'nomes_exibicao' => $nomes
            ]);
        }

        return back()->with('status', 'Lista atualizada com sucesso!');
    }



    public function editarNomes(Request $request)
    {
        $request->validate([
            'turma' => 'required',
            'nomes_exibicao.*' => 'nullable|string|max:255'
        ]);

        $registro = ListaMaterial::where('turma', $request->turma)->first();

        if (!$registro) {
            return back()->with('erro', 'Lista não encontrada.');
        }

        // Pega array atual de nomes
        $nomes = $registro->nomes_exibicao ?? [];

        // Se for SALVAMENTO INDIVIDUAL
        if ($request->has('salvar_individual')) {

            $index = (int) $request->salvar_individual;

            // Atualiza somente esse nome
            $nomes[$index] = $request->nomes_exibicao[$index] ?? 'Arquivo';

            // Salva
            $registro->update([
                'nomes_exibicao' => $nomes
            ]);

            return back()->with('status', 'Nome atualizado!');
        }

        // Se algum dia quiser salvar todos de uma vez (opcional)
        $registro->update([
            'nomes_exibicao' => $request->nomes_exibicao
        ]);

        return back()->with('status', 'Nomes atualizados!');
    }




    public function removerArquivo(Request $request)
    {
        $request->validate([
            'turma' => 'required',
            'arquivo' => 'required'
        ]);

        $registro = ListaMaterial::where('turma', $request->turma)->first();

        if (!$registro) {
            return back()->with('erro', 'Lista não encontrada.');
        }

        $arquivos = $registro->arquivo ?? [];
        $nomes = $registro->nomes_exibicao ?? [];

        // Encontrar índice do arquivo removido
        $index = array_search($request->arquivo, $arquivos);

        if ($index === false) {
            return back()->with('erro', 'Arquivo não encontrado.');
        }

        // Remover arquivo e nome correspondente
        unset($arquivos[$index]);
        unset($nomes[$index]);

        // Reindexa arrays
        $arquivos = array_values($arquivos);
        $nomes = array_values($nomes);

        // Remove do storage
        \Storage::disk('public')->delete($request->arquivo);

        $registro->update([
            'arquivo' => $arquivos,
            'nomes_exibicao' => $nomes
        ]);

        return back()->with('status', 'Arquivo removido com sucesso!');
    }
}
