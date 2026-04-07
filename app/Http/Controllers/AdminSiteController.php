<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfiguracaoSite;
use Illuminate\Support\Facades\Storage;

class AdminSiteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin'); // guard admin
    }

    public function index()
    {
        // garante sempre um registro único
        $config = ConfiguracaoSite::firstOrCreate(
            ['id' => 1],
            [
                'titulo_missao' => '',
                'paragrafo1' => '',
                'paragrafo2' => '',
                'imagem_hero' => null
            ]
        );

        return view('admin.site-config', compact('config'));
    }

    public function salvar(Request $request)
    {
        $request->validate([
            'titulo_missao' => 'nullable|string|max:255',
            'paragrafo1' => 'nullable|string',
            'paragrafo2' => 'nullable|string',
            'imagem_hero' => 'nullable|image|max:2048', // 2MB
        ]);

        // sempre pega o registro único
        $config = ConfiguracaoSite::firstOrCreate(['id' => 1]);

        $config->titulo_missao = $request->titulo_missao;
        $config->paragrafo1 = $request->paragrafo1;
        $config->paragrafo2 = $request->paragrafo2;

        if ($request->hasFile('imagem_hero')) {

            // remove antiga se existir
            if ($config->imagem_hero && Storage::disk('public')->exists($config->imagem_hero)) {
                Storage::disk('public')->delete($config->imagem_hero);
            }

            $path = $request->file('imagem_hero')->store('site', 'public');
            $config->imagem_hero = $path;
        }

        $config->save();

        return redirect()->route('admin.dashboard')
            ->with('status', 'Configurações atualizadas com sucesso!');

    }
}
