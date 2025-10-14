<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Models\User;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ProfissionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Profissional::query();

        // Lógica para filtrar por string de busca
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nome', 'LIKE', '%' . $search . '%');
        }

        $usuarios = User::all();
        $departamentos = Departamento::all();
        $profissionais = $query->with('user', 'departamento')->paginate(10);

        return view('profissional.index', compact('profissionais', 'usuarios', 'departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // PRIMEIRO CADASTRAR O LOGIN DO PROFISSIONAL NA TEBELA USERS
        // DEPOIS CADASTRAR O PROFISSIONAL NA TABELA PROFISSIONAIS
        $email_profissional = $request->input('create_email');
        $nome_profissional = $request->input('create_nome');
        $passoword_profissional = Hash::make('123456'); // Senha padrão inicial

        // Apenas validação, sem checagem manual
        $validated = $request->validate([
            'create_email' => 'required|email',
            'create_nome' => 'required|string|max:50',
            'create_telefone' => 'required|string|max:15',
            'create_tipo_usuario' => 'required|integer|in:1,2',
            'create_departamento' => 'required|exists:departamentos,id',
            'create_tipo_acesso' => 'required|string|in:Admin,Gestor,PDD,Relacionamento,Operacional,ÁreaTécnica,SemAcesso',
        ]);

        $emailExiste = User::where('email', $email_profissional)->first();
        if ($emailExiste) {
            return redirect()->back()->withInput()->with('error', 'O email fornecido já está em uso. Por favor, use outro email.');
        }
        try {
            // Criar o usuário primeiro
            $user = User::create([
                'name' => $nome_profissional,
                'email' => $email_profissional,
                'password' => $passoword_profissional,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao criar usuário: ' . $e->getMessage());
        }

        // Buscar o ID do usuário para vincular ao profissional em seguida criar
        $user_id = $user->id;

        try {
            // Criar o profissional
            $profissional = Profissional::create([
                'user_id' => $user_id,
                'nome' => $request->input('create_nome'),
                'telefone' => preg_replace('/[^0-9]/', '', $request->input('create_telefone')),
                'departamento_id' => (int)$request->input('create_departamento'),
                'tipo_usuario' => $request->input('create_tipo_usuario'),
                'tipo_acesso' => $request->input('create_tipo_acesso'),
            ]);
            return redirect()->route('profissional.index')->with('success', 'Profissional <strong>' . $profissional->nome . '</strong> criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao criar profissional: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Profissional $profissional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profissional $profissional)
    {
        //
    }


    // Update é para alterar o profissional   
    public function update(Request $request, Profissional $profissional)
    {
        // Primeiro esta validando o se o email do profissional existe
        $email_profissional = $request->input('update_email');
        $user_id = User::where('email', $email_profissional)->value('id');

        if (!$user_id) {
            return redirect()->back()->withInput()->with('error', 'Usuário com o email fornecido não existe.');
        }

        $verifica_profissional = Profissional::where('id', $request->input('id'));

        if (!$verifica_profissional) {
            return redirect()->back()->withInput()->with('error', 'Este profissional não foi encontrado.');
        }

        try {
            // Validar os dados
            $validated = $request->validate([
                'update_email' => 'required|email',
                'update_nome' => 'required|string|max:50',
                'update_telefone' => 'required|string|max:15',
                'update_tipo_usuario' => 'required|integer|in:1,2',
                'update_departamento' => 'required|exists:departamentos,id',
                'update_tipo_acesso' => 'required|string|in:Admin,Gestor,PDD,Relacionamento,Operacional,ÁreaTécnica,SemAcesso',
            ]);
            $profissional = Profissional::where('id', $request->input('id'))->update([
                'user_id' => $user_id,
                'nome' => $request->input('update_nome'),
                'telefone' => preg_replace('/[^0-9]/', '', $request->input('update_telefone')),
                'departamento_id' => (int)$request->input('update_departamento'),
                'tipo_usuario' => $request->input('update_tipo_usuario'),
                'tipo_acesso' => $request->input('update_tipo_acesso'),
            ]);
            return redirect()->route('profissional.index')->with('success', "Profissional {$request->input('update_nome')} alterado com sucesso!");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao alterar profissional: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */


    public function toggle(Request $request, Profissional $profissional)
    {

        // Busca o profissional pelo id do request (caso não venha pelo model binding)
        $profissional = Profissional::find($request->input('id', $profissional->id)); // Alterado para buscar pelo ID
        if (!$profissional) {
            return redirect()->back()->with('error', 'Profissional não encontrado.');
        }

        try {
            // Alterar o status do profissional
            $profissional->profissional_ativo = !$profissional->profissional_ativo; // Inverte o status
            $profissional->save();
            // Bloqueia ou desbloqueia o login do profissional com base no status
            $this->bloquearLogin($profissional->user_id, $profissional->profissional_ativo);

            $status_text = $profissional->profissional_ativo ? 'ativado' : 'desativado';
            return redirect()->route('profissional.index')->with('success', "Profissional {$profissional->nome} {$status_text} com sucesso!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao alterar status do profissional: ' . $e->getMessage());
        }
    }

    private function bloquearLogin($user_id, $bloquear)
    {
        try {
            // Lógica para bloquear o login do profissional
            $user = User::find($user_id);
            $user->user_bloqueado = !$bloquear; // Alterado para definir o status com base no parâmetro
            $user->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }




    public function destroy(Request $request, Profissional $profissional)
    {
        try {
            \App\Models\Profissional::where('id', $request->delete_id)->delete();
            return redirect()->route('profissional.index')
                ->with('success', "Profissional {$request->input('update_nome')} deletado com sucesso!");
        } catch (\Exception $e) {
            if ($e->getCode() == "23000") { // erro de integridade (FK)
                return redirect()->route('profissional.index')
                    ->with('error', 'Não é possível excluir este profissional.');
            }

            // caso seja outro erro
            return redirect()->route('profissional.index')
                ->with('error', 'Erro ao excluir o profissional. Tente novamente.');
        }
    }
}
