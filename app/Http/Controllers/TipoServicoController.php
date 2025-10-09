<?php

namespace App\Http\Controllers;

use App\Models\Tipo_servico;
use Illuminate\Http\Request;

class TipoServicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo_servicos = Tipo_servico::with('departamento')->paginate(12);
        $departamentos = \App\Models\Departamento::all();
        return view('tipoServico.index', compact('tipo_servicos', 'departamentos'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tipo_servico $tipo_servico)
    {
        //
    }
}
