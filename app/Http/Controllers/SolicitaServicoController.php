<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Tipo_servico;
use App\Models\Departamento;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class SolicitaServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Obtém o ID do usuário autenticado
        $userId = Auth::id();

        // 2. Inicia a query e filtra os tickets onde 'user_id_solicitante' é igual ao $userId
        $query = Ticket::query()
            ->where('user_id_solicitante', $userId) // <--- ESTA É A LINHA CHAVE
            ->orderBy('updated_at', 'desc');

        // Lógica para filtrar por string de busca (se necessário)
        if (request()->filled('search')) {
            $search = request()->input('search');
            $query->where('numero_ticket', 'LIKE', '%' . $search . '%');
        }

        // 3. Executa a query com as relações e paginação
        $solicitaServicos = $query->with(['tipo_servico', 'empresa', 'user_solicitante', 'user_executante'])->paginate(10);

        $tiposServicos = \App\Models\Tipo_servico::where('servico_ativo', true)->select('id', 'nome_servico', 'titulo_nome')->get();
        $departamentos = \App\Models\Departamento::pluck('nome', 'id');
        $grupoUsuarioLogado = \App\Models\Profissional::where('user_id', $userId)->first()->grupo_id;
        $empresas = \App\Models\Empresa::where('id_grupo', $grupoUsuarioLogado)->pluck('nome_fantasia', 'id');

        return view('solicitaServico.index', compact('solicitaServicos', 'tiposServicos', 'departamentos', 'empresas'));
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
        $validated = $request->validate([
            'descricao_servico' => 'required',
            'tipo_servico_id' => 'required',
            'origem_sigla_depto' => 'nullable',
            'user_id_solicitante' => 'required',
            'empresa_id' => 'required',
            'observacoes' => 'nullable',
            'data_solicitacao' => 'required|date',
        ]);

        try {
            // 1️⃣ Pega o tipo de serviço
            $tipoServico = Tipo_servico::findOrFail($request->input('tipo_servico_id'));

            // 2️⃣ Pega o departamento executante e sua sigla
            $departamento = Departamento::findOrFail($tipoServico->executante_departamento_id);
            $siglaDepto = strtoupper($departamento->sigla_depto);

            // 3️⃣ Pega o ID do executante (se o tipo_servico já define quem executa)
            // Aqui você pode mudar para o usuário executante padrão
            $executante = \App\Models\Profissional::where('departamento_id', $departamento->id)->first();
            $userExecutanteId = $executante ? $executante->id : null;

            // 4️⃣ Calcula o próximo número do ticket
            $ultimoTicket = \App\Models\Ticket::where('numero_ticket', 'like', $siglaDepto . '-%')
                ->orderBy('id', 'desc')
                ->first();

            $novoNumero = $ultimoTicket ? str_pad(intval(substr($ultimoTicket->numero_ticket, strlen($siglaDepto) + 1)) + 1, 4, '0', STR_PAD_LEFT) : '0001';

            $numeroTicket = $siglaDepto . '-' . $novoNumero;

            // 5️⃣ Cria o ticket
            \App\Models\Ticket::create([
                'numero_ticket' => $numeroTicket,
                'descricao_servico' => $request->input('descricao_servico'),
                'tipo_servico_id' => $request->input('tipo_servico_id'),
                'origem_sigla_depto' => $request->input('create_user_departamento'),
                'user_id_solicitante' => $request->input('user_id_solicitante'),
                'user_id_executante' => null, // automático
                'empresa_id' => $request->input('empresa_id'),
                'observacoes' => $request->input('observacoes'),
                'data_solicitacao' => $request->input('data_solicitacao'),
                'data_conclusao' => null,
                'data_devolucao' => null,
                'status_final' => 'Aberto', // sempre começa como Aberto
            ]);

            return redirect()
                ->route('solicitaServico.index')
                ->with('success', 'Ticket <strong>' . $numeroTicket . '</strong> criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao criar ticket: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tickets = \App\Models\Ticket::findOrFail($id);

        if (!$tickets) {
            return redirect()->back()->with('Error', 'Não foi possivel atualizar o ticket tente novamente.');
        }
        try {
            $validated = $request->validate(
                [
                    'descricao_servico' => 'required',
                    'tipo_servico_id' => 'required',
                    'empresa_id' => 'required',
                ],
                [
                    'descricao_servico.required' => 'O campo Descricao do Servico é obrigatório.',
                    'tipo_servico_id.required' => 'O campo Tipo de Servico é obrigatório.',
                    'empresa_id.required' => 'O campo Empresa é obrigatório.',
                ],
            );

            if ($validated) {
                $tickets->update([
                    'descricao_servico' => $request->input('descricao_servico'),
                    'tipo_servico_id' => $request->input('tipo_servico_id'),
                    'empresa_id' => $request->input('empresa_id'),
                ]);
                return redirect()
                    ->route('solicitaServico.index')
                    ->with('success', 'Ticket <strong>' . $request->input('numero_ticket') . '</strong> atualizado com sucesso!');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erro ao atualizar ticket: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $servicoDeletado = \App\Models\Ticket::findOrFail($id);
            if (!$servicoDeletado) {
                return redirect()->back()->with('error', 'Não foi possivel excluir o ticket, verifique e tente novamente.');
            }
            $servicoDeletado->delete();
        } catch (\Exception $e) {
            Log::error('Erro ao excluir ticket: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Não foi possivel excluir o ticket.');
        }

        return redirect()
            ->route('solicitaServico.index')
            ->with('success', 'Ticket <strong>' . $servicoDeletado->numero_ticket . '</strong> Excluido com sucesso!');
    }
}
