<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Enums\StatusTickets;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1️⃣ Pega o ID do usuário logado
        $userId = Auth::id();

        // 2️⃣ Obtém o departamento do profissional vinculado ao usuário
        $profissional = \App\Models\Profissional::where('user_id', $userId)->first();

        if (!$profissional) {
            $tickets = collect();
            return view('ticket.index', compact('tickets'));
        }

        $departamentoId = $profissional->departamento_id;

        // 3️⃣ INICIA o construtor de query, mas não o executa
        $query = \App\Models\Ticket::with(['tipo_servico', 'empresa', 'user_solicitante', 'user_executante'])
            // Filtro de Departamento (mantido)
            ->whereHas('tipo_servico', function ($q) use ($departamentoId) {
                $q->where('executante_departamento_id', $departamentoId);
            })

            // Aplica a ordenação
            ->orderByDesc('updated_at');

        // Lógica para filtrar por string de busca (CORREÇÃO)
        if (request()->filled('search')) {
            $search = request()->input('search');
            // Adiciona a condição WHERE no construtor de query
            $query->where('numero_ticket', 'LIKE', '%' . $search . '%');

            // Se você quiser buscar em múltiplos campos:
            // $query->where(function ($q) use ($search) {
            //     $q->where('numero_ticket', 'LIKE', "%{$search}%")
            //       ->orWhere('descricao_servico', 'LIKE', "%{$search}%");
            // });
        }

        // Lógica para filtrar por status final
        if (request()->filled('select_statusFinal')) {
            $statusFinalSelected = request()->input('select_statusFinal');

            // 1. Condição para filtrar, IGNORANDO se for 'Todos'
            if ($statusFinalSelected !== 'Todos') {
                // 2. Adiciona a condição WHERE no construtor de query
                // Correção da sintaxe: deve ser 'coluna', 'operador', 'valor'
                $query->where('status_final', '=', $statusFinalSelected);
            }
            // Se for 'Todos', a query não adiciona nenhuma condição de status_final, listando todos.
        }

        // Lógica para filtrar por Data
        if (request()->filled('data_ticket')) {
            $dataTicket = request()->input('data_ticket');

            // 1. Condição para filtrar, IGNORANDO se for 'Todos'
            if ($dataTicket !== null) {
                // 2. Adiciona a condição WHERE no construtor de query
                // Correção da sintaxe: deve ser 'coluna', 'operador', 'valor'
                $query->whereDate('data_solicitacao', '=', $dataTicket);
            }
            // Se for 'Todos', a query não adiciona nenhuma condição de status_final, listando todos.
        }

        // 4️⃣ EXECUTA a query e pagina os resultados
        $tickets = $query->paginate(10);
        $statusFinals = StatusTickets::cases();

        // 5️⃣ Retorna a view com os tickets
        return view('ticket.index', compact('tickets', 'statusFinals'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function aceitarAtendimento($ticket_id)
    {
        // 1. Encontra o ticket
        $ticket = Ticket::find($ticket_id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket não encontrado.'], 404);
        }

        // 2. Obtém o ID do usuário logado
        $executorId = Auth::user()->id;

        // 3. Aplica a alteração (user_id_executante)
        try {
            $ticket->user_id_executante = $executorId;
            // Opcional: Mudar o status para "Em Andamento" ou similar
            $ticket->status_final = 'Em Andamento';
            $ticket->save();

            // 4. Retorna a resposta de sucesso
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Atendimento aceito e atribuído.',
            ]);
        } catch (\Exception $e) {
            // Retorna o erro
            Log::error('Erro ao salvar o ticket: ' . $e->getMessage());
            return response()->json(
                [
                    'status' => 500,
                    'success' => false,
                    'message' => 'Erro ao salvar o ticket: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function devolverAtendimento(Request $request, $ticket_id)
    {
        // dd($ticket_id);
        // 1. Encontra o ticket
        $ticket = Ticket::find($ticket_id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket não encontrado.'], 404);
        }

        // Texto anterior no banco
        $observacoesAnteriores = trim($request->input('observacoesAnteriores', ''));
        Log::info('Ao alterar o observação Anteriores: ' . $observacoesAnteriores);

        // Novo texto digitado
        $novoTexto = trim($request->input('observacoes', ''));

        // Registro de devolução com destaque
        $registroDevolucao = '<strong>Devolvido por: ' . Auth::user()->name . ' em ' . now()->format('d-m-Y H:i:s') . '</strong>';

        // Monta o histórico corretamente
        $partes = [];

        if (!empty($observacoesAnteriores)) {
            $partes[] = $observacoesAnteriores;
        }

        if (!empty($novoTexto)) {
            $partes[] = $novoTexto;
        }

        // Sempre adiciona o registro de devolução
        $partes[] = $registroDevolucao;

        // Junta tudo com quebra de linha
        $historicoCompleto = implode(PHP_EOL, $partes);

        Log::info('Ao alterar o observação: ' . $historicoCompleto);
        // 2. Aplica a alteração (user_id_executante)
        try {
            // Opcional: Mudar o status para "Em Andamento" ou similar
            $ticket->status_final = 'Devolvido';
            $ticket->data_devolucao = now();
            $ticket->observacoes = $historicoCompleto;
            $ticket->save();

            // 4. Retorna a resposta de sucesso
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Atendimento aceito e atribuído.',
            ]);
        } catch (\Exception $e) {
            // Retorna o erro
            Log::error('Erro ao salvar o ticket: ' . $e->getMessage());
            return response()->json(
                [
                    'status' => 500,
                    'success' => false,
                    'message' => 'Erro ao salvar o ticket: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function encerrarAtendimento($ticket_id)
    {
        // 1. Encontra o ticket
        $ticket = Ticket::find($ticket_id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket não encontrado.'], 404);
        }

        // 2. Aplica a alteração (user_id_executante)
        try {

            // 3. Calcula o tempo que tomou para resolver o ticket
            $sla = $ticket->tipo_servico?->sla?->tempo_limite_minutos ?? 15; // Obtém o tempo limite do SLA do tipo de serviço
            $tempoExecucao = $ticket->data_solicitacao->diffInMinutes(now()); // Verifica a diferença em minutos

            Log::info('Tempo limite de SLA obtido: ' . $sla . ' minutos.');
            Log::info('Tempo de execução do ticket: ' . $tempoExecucao . ' minutos.');

                           
            $cumpriu = ($tempoExecucao <= $sla) ? 0 : 1;

            // 4. Atualiza o ticket
            $ticket->cumpriu_sla = $cumpriu;
            $ticket->tempo_execucao = $tempoExecucao;
            $ticket->data_conclusao = now();
            $ticket->status_final = 'Concluído';
            $ticket->save();

            // 5. Retorna a resposta de sucesso
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Atendimento encerrado.',
            ]);
        } catch (\Exception $e) {
            // Retorna o erro
            Log::error('Erro ao encerrar o ticket: ' . $e->getMessage());
            return response()->json(
                [
                    'status' => 500,
                    'success' => false,
                    'message' => 'Erro ao encerrar o ticket: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $tickets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $tickets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $tickets)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $tickets)
    {
        //
    }
}
