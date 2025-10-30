<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
            ->orderByDesc('prioridade');


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

        // 4️⃣ EXECUTA a query e pagina os resultados
        $tickets = $query->paginate(10);

        // 5️⃣ Retorna a view com os tickets
        return view('ticket.index', compact('tickets'));
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
        $executorId = auth()->id();

        // 3. Aplica a alteração (user_id_executante)
        try {
            $ticket->user_id_executante = $executorId;
            // Opcional: Mudar o status para "Em Andamento" ou similar
            $ticket->status = 'Em Andamento'; 
            $ticket->save();

            // 4. Retorna a resposta de sucesso
            return response()->json([
                'status' => 200,
                'success' => true,
                'message' => 'Atendimento aceito e atribuído.'
            ]);
        } catch (\Exception $e) {
            // Retorna o erro
            Log::error('Erro ao salvar o ticket: ' . $e->getMessage());
            return response()->json([
                'status' => 500,
                'success' => false,
                'message' => 'Erro ao salvar o ticket: ' . $e->getMessage()
            ], 500);
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
