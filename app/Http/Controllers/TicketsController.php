<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 1️⃣ Pega o ID do usuário logado
        $userId = auth()->id();

        // 2️⃣ Obtém o departamento do profissional vinculado ao usuário
        $profissional = \App\Models\Profissional::where('user_id', $userId)->first();

        if (!$profissional) {
            // Se o usuário não estiver vinculado a um profissional, retorna vazio
            $tickets = collect();
            return view('ticket.index', compact('tickets'));
        }

        $departamentoId = $profissional->departamento_id;

        // 3️⃣ Busca os tickets cujo tipo_servico pertence ao mesmo departamento do usuário logado
        $tickets = \App\Models\Ticket::with(['tipo_servico', 'empresa', 'user_solicitante', 'user_executante'])
            ->whereHas('tipo_servico', function ($query) use ($departamentoId) {
                $query->where('executante_departamento_id', $departamentoId);
            })
            ->orderByDesc('id')
            ->paginate(10);

        // 4️⃣ Retorna a view com os tickets
        return view('ticket.index', compact('tickets'));
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
