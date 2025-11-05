## STATUS DOS BUTTONS 

 case Aberto = 'Aberto'; 
    -> Todos os buttons ficam aparecendo 
 
case EmAndamento = 'Em Andamento'; 
    -> Desabilita o button Atender
    -> Habilita todos os outros 

case Pendente = 'Pendente';
    -> Desabilita o button Atender
    -> Habilita todos os outros

case Devolvido = 'Devolvido';
    -> Mostra so o botão cancelar ate o status mudar para em aberto
    -> Desabilita todos os buttons
    
case Concluido = 'Concluído';
    -> Mostra so o botão cancelar


# Filtro antigo dos TICKETS
<!-- 
 <form method="GET" action="{{ route('ticket.index') }}" class="input-group w-25">

                    <input type="search" name="search" id="search" value="{{ old('search') ?? request('search') }}"
                        class="form-control rounded-start" placeholder="Digite o numero do ticket" aria-label="Buscar">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="material-icons" data-bs-toggle="tooltip" title="Incluir">search</i>
                    </button>
                </form>

                <!-- Select Status -->
                <form method="GET" action="{{ route('ticket.index') }}" class="input-group w-25">

                    <select name="select_statusFinal" id="select_statusFinal" class="form-select form-control">

                        <option value="Todos" @selected(request('select_statusFinal') == 'Todos' || !request('select_statusFinal'))>
                            Todos
                        </option>

                        @foreach ($statusFinals as $statusFinal)
                            <option value="{{ $statusFinal->value }}" {{-- Seleciona a opção se ela for igual ao valor na URL --}}
                                @selected(request('select_statusFinal') == $statusFinal->value)>
                                {{ $statusFinal->value }}
                            </option>
                        @endforeach

                    </select>

                    <button type="submit" id="submit_status_filter" class="d-none"></button>
                </form> -->