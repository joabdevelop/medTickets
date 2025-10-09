<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = \App\Models\Departamento::orderBy('nome')->paginate(10);
        return view('departamento.index', compact('departamentos'));


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

        try {

            $validated = $request->validate([
                'create_nome' => 'required|string|max:30',
                'create_sigla' => 'required|string|max:10',
            ]);

            $departamento = new \App\Models\Departamento();
            $departamento->nome = $validated['create_nome'];
            $departamento->sigla_depto = $validated['create_sigla'];
            $departamento->save();

            return redirect()->route('departamento.index')->with('success', 'Departamento <strong>' . $departamento->nome . '</strong> criado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao criar departamento: ' . $e->getMessage());
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
    public function update(Request $request, string $id)
    {
       $departamento = \App\Models\Departamento::find($id);

        if (!$departamento) {
            return redirect()->back()->withInput()->with('error', 'Departamento não encontrado.');
        }

        try {
            $validated = $request->validate([
                'update_nome' => 'required|string|max:30',
                'update_sigla' => 'required|string|max:10',
            ]);

            $departamento->nome = $validated['update_nome'];
            $departamento->sigla_depto = $validated['update_sigla'];
            $departamento->save();

            return redirect()->route('departamento.index')->with('success', 'Departamento <strong>' . $departamento->nome . '</strong> atualizado com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar departamento: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
