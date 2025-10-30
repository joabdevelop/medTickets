<?php

namespace App\Http\Controllers;

use App\Enums\Prioridad;
use App\Enums\QuemSolicita;
use App\Models\Tipo_servico;
use Illuminate\Http\Request;

class TipoServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $departamentos = \App\Models\Departamento::where('id', '!=', 1)->pluck('nome', 'id');
        $slas = \App\Models\Sla::pluck('nome_sla', 'id');
        $query = \App\Models\Tipo_servico::query()->orderBy('created_at', 'desc');

        // Lógica para filtrar por string de busca (se necessário)
        if (request()->filled('search')) {
            $search = request()->input('search');
            $query->where('nome_servico', 'LIKE', '%' . $search . '%');
        }

        $tipo_servicos = $query->with(['departamento'])->paginate(10);
        $quemSolicitas = QuemSolicita::cases();
        $prioridades = Prioridad::cases();

        return view('tipoServico.index', compact('tipo_servicos', 'departamentos', 'slas', 'quemSolicitas', 'prioridades'));
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
        // Validação dos dados recebidos

        $validated = $request->validate([
            'create_nome_servico' => 'required|string|max:50|unique:tipo_servicos,nome_servico',
            'create_titulo_nome' => 'required|string|max:50|unique:tipo_servicos,titulo_nome',
            'create_prioridade' => 'required|in:alta,media,baixa,urgente',
            'create_executante_departamento_id' => 'required|exists:departamentos,id',
            'create_sla' => 'required|exists:slas,id',
            'create_dados_add' => 'nullable|in:0,1,2',
            'create_quem_solicita' => 'required|in:0,1,2',
            'create_servico_ativo' => 'required|boolean',
        ], [
            'create_nome_servico.required' => 'O campo Nome do Serviço é obrigatório.',
            'create_nome_servico.unique' => 'O Nome do Serviço escolhido ja existe.',
            'create_titulo_nome.required' => 'O campo Nome da solicitação é obrigatório.',
            'create_titulo_nome.unique' => 'O Nome da solicitação escolhido ja existe.',
            'create_prioridade.required' => 'O campo Prioridade é obrigatório.',
            'create_executante_departamento_id.required' => 'O campo Departamento de Execução é obrigatório.',
            'create_sla.required' => 'O campo SLA é obrigatório.',
            'create_dados_add.required' => 'O campo Dados Adicionais é obrigatório.',
            'create_quem_solicita.required' => 'O campo Quem Solicita é obrigatório.',
            'create_servico_ativo.required' => 'O campo Status é obrigatório.',
        ]);
        try {
            // Criação do novo Tipo de Serviço
            Tipo_servico::create([
                'nome_servico' => $validated['create_nome_servico'],
                'titulo_nome' => $validated['create_titulo_nome'],
                'prioridade' => $validated['create_prioridade'],
                'executante_departamento_id' => $validated['create_executante_departamento_id'],
                'sla' => $validated['create_sla'],
                'dados_add' => $validated['create_dados_add'],
                'quem_solicita' => $validated['create_quem_solicita'],
                'servico_ativo' => $validated['create_servico_ativo'],
            ]);

            return redirect()->route('tipo_servico.index')->with('success', 'Tipo de Serviço criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao criar Tipo de Serviço: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tipo_servico $tipo_servico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tipo_servico $tipo_servico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tipo_servico $tipo_servico)
    {
        try {
            $servicoAtivo = $request->boolean('update_servico_ativo');
            $validated = $request->validate([
                'update_nome_servico' => 'required|string|max:50',
                'update_titulo_nome' => 'required|string|max:50',
                'update_prioridade' => 'required|in:alta,media,baixa,urgente',
                'update_executante_departamento_id' => 'required|exists:departamentos,id',
                'update_sla' => 'required|exists:slas,id',
                'update_dados_add' => 'nullable|in:0,1,2',
                'update_quem_solicita' => 'required|in:0,1,2',

            ], [
                'update_nome_servico.required' => 'O campo Nome do Serviço é obrigatório.',
                'update_nome_servico.unique' => 'O Nome do Serviço escolhido ja existe.',
                'update_titulo_nome.required' => 'O campo Nome da solicitação é obrigatório.',
                'update_titulo_nome.unique' => 'O Nome da solicitação escolhido ja existe.',
                'update_prioridade.required' => 'O campo Prioridade é obrigatório.',
                'update_executante_departamento_id.required' => 'O campo Departamento de Execução é obrigatório.',
                'update_sla.required' => 'O campo SLA é obrigatório.',
                'update_dados_add.required' => 'O campo Dados Adicionais é obrigatório.',
                'update_quem_solicita.required' => 'O campo Quem Solicita é obrigatório.',
            ]);

            if ($validated) {
                $tipo_servico->update([
                    'nome_servico' => $validated['update_nome_servico'],
                    'titulo_nome' => $validated['update_titulo_nome'],
                    'prioridade' => $validated['update_prioridade'],
                    'executante_departamento_id' => $validated['update_executante_departamento_id'],
                    'sla' => $validated['update_sla'],
                    'dados_add' => $validated['update_dados_add'],
                    'quem_solicita' => $validated['update_quem_solicita'],
                    'servico_ativo' => $servicoAtivo, // Atualiza o campo servico_ativo
                ]);

                return redirect()->route('tipo_servico.index')->with('success', 'Serviço <strong>' . $tipo_servico->nome_servico . '</strong> foi alterado com sucesso!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar Tipo de Serviço: ' . $e->getMessage());
        }
    }

    public function toggleServicoAtivo(Tipo_servico $tipo_servico)
    {
        try {
            // CRÍTICO: Inverte o valor booleano atual
            $novoStatus = !$tipo_servico->servico_ativo;

            $tipo_servico->update([
                'servico_ativo' => $novoStatus,
            ]);

            $statusMsg = $novoStatus ? 'ATIVO' : 'INATIVO';

            return redirect()->route('tipo_servico.index')->with(
                'success',
                'O serviço <strong>' . $tipo_servico->nome_servico . '</strong> foi alterado para ' . $statusMsg . ' com sucesso!'
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao alterar status do serviço: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipo_servico $tipo_servico)
    {
        //
    }
}
