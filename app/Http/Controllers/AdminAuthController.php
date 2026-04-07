<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function formLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'senha' => 'required',
        ]);

        $usuario = Administrador::where('nome_usuario', $request->usuario)
                    ->orWhere('email_admin', $request->usuario)
                    ->first();

        if (!$usuario || !Hash::check($request->senha, $usuario->senha)) {
            return back()->withErrors(['login' => 'Credenciais inválidas!']);
        }

        auth('admin')->login($usuario);
        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        auth('admin')->logout();
        return redirect()->route('admin.login');
    }


    /* ============================================================
       RECUPERAR SENHA – ENVIAR LINK
    ============================================================ */
    public function formEsqueciSenha()
    {
        return view('admin.esqueci-senha');
    }

    public function enviarLinkRecuperacao(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        // RATE LIMIT (5 tentativas por hora por IP)
        if (RateLimiter::tooManyAttempts("recover:" . $request->ip(), 5)) {
            return back()->withErrors([
                'email' => 'Muitas tentativas. Tente novamente mais tarde.'
            ]);
        }

        RateLimiter::hit("recover:" . $request->ip(), 3600);

        $admin = Administrador::where('email_admin', $email)->first();

        // SEMPRE retorna a mesma mensagem (não vaza e-mail existente)
        $mensagem = "Se o e-mail estiver cadastrado, você receberá um link para redefinição.";

        if (!$admin) {
            return back()->with('status', $mensagem);
        }

        // Criar token
        $token = Str::random(64);

        $admin->reset_token = $token;
        $admin->token_expira = now()->addMinutes(30);
        $admin->save();

        // Enviar e-mail
        Mail::raw(
            "Clique no link para redefinir sua senha:\n" .
            url('/admin/redefinir-senha/' . $token),
            function ($message) use ($email) {
                $message->to($email)
                        ->subject("Recuperação de Senha - Escola Ana Clara");
            }
        );

        return back()->with('status', $mensagem);
    }


    /* ============================================================
       REDEFINIR SENHA
    ============================================================ */
    public function formRedefinirSenha($token)
    {
        return view('admin.redefinir-senha', compact('token'));
    }

    public function salvarNovaSenha(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'senha' => 'required|min:6|confirmed',
        ]);

        // Localiza admin pelo token
        $admin = Administrador::where('reset_token', $request->token)->first();

        if (!$admin) {
            return back()->withErrors(['token' => 'Token inválido.']);
        }

        // Verificar email corresponde ao mesmo administrador
        if ($admin->email_admin !== $request->email) {
            return back()->withErrors(['email' => 'E-mail não corresponde ao token.']);
        }

        // Verificar expiração
        if ($admin->token_expira < now()) {
            return back()->withErrors(['token' => 'Token expirado.']);
        }

        // Atualizar senha
        $admin->senha = Hash::make($request->senha);
        $admin->reset_token = null;
        $admin->token_expira = null;
        $admin->save();

        return redirect()->route('admin.login')
            ->with('status', 'Senha redefinida com sucesso!');
    }

}
