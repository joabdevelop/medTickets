<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Grupo;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Grupo::query();
        // Lógica para filtrar por string de busca (se necessário)
       
        if (request()->filled('search')) {
            $search = request()->input('search');
            $query->where('nome_grupo', 'LIKE', '%' . $search . '%');
        }

        
        $grupos = $query->with('profissional')->paginate(10);
       
        $relacionamentos = \App\Models\Profissional::pluck('nome', 'id');
        return view('grupo.index', compact('grupos','relacionamentos'));
    }

    public function empresas(Grupo $grupo)
{
    // Retorna as empresas do grupo em JSON
    return response()->json($grupo->empresas);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $nome_grupo = $request->create_nome;
        $relacionamento_id = $request->create_relacionamento;
        try {
            \App\Models\Grupo::create([
                'nome_grupo' => $nome_grupo,
                'relacionamento_id' => $relacionamento_id
            ]);

            return redirect()->route('grupo.index')
                ->with('success', "Grupo <b>{$nome_grupo}</b> criado com sucesso.");
        } catch (QueryException $e) {
            // Erros de banco (constraint, duplicate, etc)
            return redirect()->route('grupo.index')
                ->with('error', 'Não foi possível criar o grupo. Verifique os dados e tente novamente.');
        } catch (\Exception $e) {
            // Qualquer outro erro inesperado
            return redirect()->route('grupo.index')
                ->with('error', 'Ocorreu um erro inesperado. Por favor, tente novamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $nome_grupo = $request->update_nome;
        $relacionamento_id = $request->update_relacionamento;
        \App\Models\Grupo::where('id', $request->update_id)->update(['nome_grupo' => $nome_grupo, 'relacionamento_id' => $relacionamento_id]);
        return redirect()->route('grupo.index')->with('success', 'Grupo <b>' . $nome_grupo . '</b> atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            \App\Models\Grupo::where('id', $request->delete_id)->delete();
            return redirect()->route('grupo.index')
                ->with('success', 'Grupo deletado com sucesso!');
        } catch (QueryException $e) {
            if ($e->getCode() == "23000") { // erro de integridade (FK)
                return redirect()->route('grupo.index')
                    ->with('error', 'Não é possível excluir este grupo porque existem Empresas relacionadas.');
            }

            // caso seja outro erro
            return redirect()->route('grupo.index')
                ->with('error', 'Erro ao excluir o grupo. Tente novamente.');
        }
    }
}
