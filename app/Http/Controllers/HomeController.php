<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Ticket;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtém o usuário autenticado
        $user = Auth::user();

        // 2. Extrai o nome, usando um fallback ('Usuário') se não estiver logado ou se o nome for nulo
        // Assumimos que o modelo User tem um campo 'name'
        $userName = $user ? $user->name : 'Usuário';

        $hour = now()->hour;
        $greeting = '';

        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Bom dia';
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = 'Boa tarde';
        } else {
            $greeting = 'Boa noite';
        }

         // Lógica de filtro de data (padrão: 30 dias)
        $periodo = $request->input('periodo', 30);

        //$dataInicio = $request->input('inicio', now()->subDays($periodo)->startOfDay()->toDateString());
        $dataAtual = Carbon::now();
        $dataInicio = $dataAtual->startOfMonth()->toDateString();
        $dataFim = now()->toDateString();

        // Top 10 Tickets com Maior Tempo de Resolução
        $topTickets = Ticket::with('user_executante', 'tipo_servico')
            ->whereNotNull('tempo_execucao')
            ->where('user_id_executante', '=', $user->id)
            ->orderByDesc('tempo_execucao')
            ->limit(10)->get();

        $dados = DB::table('metricas_consolidadas')->select( 'user_id_executante', 
                 DB::raw('SUM(total_tickets) as total'), 
                 DB::raw('SUM(tickets_concluidos) as concluidos'), 
                 DB::raw('SUM(tickets_devolvidos) as devolvidos'), 
                 DB::raw('SUM(tickets_sla_ok) as sla_ok'), 
                 DB::raw('SUM(tempo_total_execucao_segundos) as tempo_total'), 
                 DB::raw('SUM(total_tickets_com_tempo) as tickets_tempo'))
                ->where('user_id_executante', '=', $user->id)
                ->whereBetween('data_metrica', [$dataInicio, $dataFim])
                ->groupBy('user_id_executante')->get();
        // Lógica para o dashboard de equipe

        // 3. Retorna a view 'home' e passa a variável 'userName'
        return view('home', [
            'userName' => $userName,
            'greeting' => $greeting,
            'dados' => $dados,
            'dataInicio' => $dataInicio,
            'dataFim' => $dataFim,
            'topTickets' => $topTickets,
        ]);
    }
}
