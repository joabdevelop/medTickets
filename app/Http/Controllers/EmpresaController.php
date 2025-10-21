<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Grupo;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $grupos = \App\Models\Grupo::pluck('nome_grupo', 'id');
        $query = \App\Models\Empresa::query()->orderBy('updated_at', 'desc');

        // Lógica para filtrar por string de busca (se necessário)
        if (request()->filled('search')) {
            $search = request()->input('search');
            $query->where('razao_social', 'LIKE', '%' . $search . '%');
        }
 
        $empresas = $query->with(['grupo', 'grupo.profissional'])->paginate(10);
        //$grupos = \App\Models\Grupo::pluck('nome_grupo', 'id');
        $nomeRelacionamento = \App\Models\Departamento::pluck('id', 'sigla_depto');
        return view('empresa.index', compact('empresas', 'nomeRelacionamento', 'grupos'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $grupos = \App\Models\Grupo::pluck('nome_grupo', 'id');
            return view('empresa.createEmpresa', compact('grupos'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar grupos no create: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('error', 'Erro ao carregar os grupos. Contate o administrador.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  dd($request->all());
        try {
            // Preparar os dados dos checkboxes (conversão automática para 0 ou 1)
            $data = $request->all();
            $data['bloqueio_status_financ'] = $request->boolean('bloqueio_status_financ');
            $data['status_produto_preco']   = $request->boolean('status_produto_preco');

            // Validação dos dados do formulário
            $validatedData = validator($data, [
                'grupo_empresarial' => 'required|exists:grupos,id',
                'nome_fantasia' => 'required|string|max:255',
                'razao_social' => 'required|string|max:255',
                'codigo_fiscal' => 'required|string|max:18|unique:empresas,codigo_fiscal',
                'email_contato' => 'required|email|max:255',
                'grupo_classificacao' => 'required|in:I,II',
                'modalidade' => 'required|in:POOL,PD SITE,NUCLEO,NUCLEO ENG,PRIME',
                'ultima_renovacao_tipo' => 'required|in:REN AUT,REN MAN',
                'fif_status' => 'required|in:OK,PENDENTE,EXPIRADO,CORTESIA',
                'FIF_data_liberacao' => 'required|date',
                'data_contrato' => 'required|date',
                'bloqueio_status_financ' => 'boolean',
                'status_produto_preco' => 'boolean',
            ], [
                'grupo_empresarial.required' => 'O campo grupo empresarial é obrigatório.',
                'grupo_empresarial.exists' => 'O grupo empresarial selecionado não existe.',
                'nome_fantasia.required' => 'O campo nome fantasia é obrigatório.',
                'nome_fantasia.string' => 'O nome fantasia deve ser uma string.',
                'nome_fantasia.max' => 'O nome fantasia não pode exceder 255 caracteres.',
                'razao_social.required' => 'O campo razão social é obrigatório.',
                'razao_social.string' => 'A razão social deve ser uma string.',
                'razao_social.max' => 'A razão social não pode exceder 255 caracteres.',
                'codigo_fiscal.required' => 'O campo código fiscal é obrigatório.',
                'codigo_fiscal.string' => 'O código fiscal deve ser uma string.',
                'codigo_fiscal.max' => 'O código fiscal não pode exceder 14 caracteres.',
                'codigo_fiscal.unique' => 'O código fiscal já está em uso.',
                'email_contato.required' => 'O campo e-mail de contato é obrigatório.',
                'email_contato.email' => 'O e-mail de contato deve ser um endereço de e-mail válido.',
                'email_contato.max' => 'O e-mail de contato não pode exceder 255 caracteres.',
                'grupo_classificacao.required' => 'O campo classificação do grupo é obrigatório.',
                'grupo_classificacao.in' => 'A classificação do grupo deve ser  I ou II.',
                'modalidade.required' => 'O campo modalidade é obrigatório.',
                'modalidade.in' => 'A modalidade deve ser POOL, PD SITE, NUCLEO, NUCLEO ENG ou PRIME.',
                'ultima_renovacao_tipo.required' => 'O campo tipo de última renovação é obrigatório.',
                'ultima_renovacao_tipo.in' => 'O tipo de última renovação deve ser REN AUT ou REN MAN.',
                'fif_status.required' => 'O campo status FIF é obrigatório.',
                'fif_status.in' => 'O status FIF deve ser OK, PENDENTE, EXPIRADO ou CORTESIA.',
                'FIF_data_liberacao.required' => 'O campo data de liberação FIF é obrigatório.',
                'FIF_data_liberacao.date' => 'A data de liberação FIF deve ser uma data válida.',
                'data_contrato.required' => 'O campo data do contrato é obrigatório.',
                'data_contrato.date' => 'A data do contrato deve ser uma data válida.',
                'bloqueio_status_financ.boolean' => 'O status de bloqueio financeiro deve ser verdadeiro ou falso.',
                'status_produto_preco.boolean' => 'O status do produto/preço deve ser verdadeiro ou falso.',
            ])->validate();

            //$validatedData['codigo_fiscal'] = preg_replace('/[^0-9]/', '', $validatedData['codigo_fiscal']);

            // Criação do registro no banco de dados
            $empresa = Empresa::create([
                'id_grupo' => $validatedData['grupo_empresarial'],
                'nome_fantasia' => $validatedData['nome_fantasia'],
                'razao_social' => $validatedData['razao_social'],
                'codigo_fiscal' => $validatedData['codigo_fiscal'],
                'email_contato' => $validatedData['email_contato'],
                'grupo_classificacao' => $validatedData['grupo_classificacao'],
                'modalidade' => $validatedData['modalidade'],
                'ultima_renovacao_tipo' => $validatedData['ultima_renovacao_tipo'],
                'fif_status' => $validatedData['fif_status'],
                'FIF_data_liberacao' => $validatedData['FIF_data_liberacao'],
                'data_contrato' => $validatedData['data_contrato'],
                'bloqueio_status_financ' => $validatedData['bloqueio_status_financ'],
                'status_produto_preco' => $validatedData['status_produto_preco'],
            ]);

            // Redireciona com mensagem de sucesso
            return redirect()->route('empresa.index')->with('success', 'Empresa ' . $request->razao_social . ' criada com sucesso!');
        } catch (ValidationException $e) {
            // Captura erros de validação e retorna ao formulário com os erros
            Log::error('Erro de validação ao criar empresa: ' . $e->getMessage(), [
                'errors' => $e->validator->errors(),
                'data' => $request->all()
            ]);
            return redirect()->back()
                ->withErrors($e->validator->errors())
                ->withInput();
        } catch (\Exception $e) {
            // Log do erro para outros tipos de exceções
            Log::error('Erro ao criar empresa: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $request->all()
            ]);

            // MUDE AQUI: back em vez de index, pra preservar contexto
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao criar a empresa. Tente novamente ou contate o administrador.')
                ->withInput(); // Preserva inputs

            // Retorna com mensagem de erro genérica
            // return redirect()->route('empresa.index')->with('error', 'Ocorreu um erro ao criar a empresa. Tente novamente ou contate o administrador.');
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


    public function edit(Empresa $empresa)  // Route model binding: injeta a empresa pelo ID
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {
      
        try {
            // Preparar os dados dos checkboxes (conversão automática para 0 ou 1)
            $data = $request->all();
            $data['bloqueio_status_financ'] = $request->boolean('bloqueio_status_financ');
            $data['status_produto_preco'] = $request->boolean('status_produto_preco');

            // Validação dos dados do formulário (mesmas regras do store, mas ignore unique no código_fiscal se for o mesmo ID)
            $validatedData = validator($data, [
                'grupo_empresarial' => 'required|exists:grupos,id',
                'nome_fantasia' => 'required|string|max:255',
                'razao_social' => 'required|string|max:255',
                'codigo_fiscal' => ['required', 'string', 'max:18'],
                'email_contato' => 'required|email|max:255',
                'grupo_classificacao' => 'required|in:I,II',
                'modalidade' => 'required|in:POOL,PD SITE,NUCLEO,NUCLEO ENG,PRIME',
                'ultima_renovacao_contrato' => 'nullable|date',
                'ultima_renovacao_tipo' => 'required|in:REN AUT,REN MAN',
                'fif_status' => 'required|in:OK,PENDENTE,EXPIRADO,CORTESIA',
                'FIF_data_liberacao' => 'required|date',
                'data_contrato' => 'required|date',
                'bloqueio_status_financ' => 'boolean',
                'status_produto_preco' => 'boolean',
            ], [
                'grupo_empresarial.required' => 'O campo grupo empresarial é obrigatório.',
                'grupo_empresarial.exists' => 'O grupo empresarial selecionado não existe.',
                'nome_fantasia.required' => 'O campo nome fantasia é obrigatório.',
                'nome_fantasia.string' => 'O nome fantasia deve ser uma string.',
                'nome_fantasia.max' => 'O nome fantasia não pode exceder 255 caracteres.',
                'razao_social.required' => 'O campo razão social é obrigatório.',
                'razao_social.string' => 'A razão social deve ser uma string.',
                'razao_social.max' => 'A razão social não pode exceder 255 caracteres.',
                'codigo_fiscal.required' => 'O campo código fiscal é obrigatório.',
                'codigo_fiscal.string' => 'O código fiscal deve ser uma string.',
                'codigo_fiscal.max' => 'O código fiscal não pode exceder 14 caracteres.',
                'codigo_fiscal.unique' => 'O código fiscal já está em uso.',
                'email_contato.required' => 'O campo e-mail de contato é obrigatório.',
                'email_contato.email' => 'O e-mail de contato deve ser um endereço de e-mail válido.',
                'email_contato.max' => 'O e-mail de contato não pode exceder 255 caracteres.',
                'grupo_classificacao.required' => 'O campo classificação do grupo é obrigatório.',
                'grupo_classificacao.in' => 'A classificação do grupo deve ser I ou II.',
                'modalidade.required' => 'O campo modalidade é obrigatório.',
                'modalidade.in' => 'A modalidade deve ser POOL, PD SITE, NUCLEO, NUCLEO ENG ou PRIME.',
                'ultima_renovacao_contrato.date' => 'A data de última renovação do contrato deve ser uma data válida.',
                'ultima_renovacao_tipo.required' => 'O campo tipo de última renovação é obrigatório.',
                'ultima_renovacao_tipo.in' => 'O tipo de última renovação deve ser REN AUT ou REN MAN.',
                'fif_status.required' => 'O campo status FIF é obrigatório.',
                'fif_status.in' => 'O status FIF deve ser OK, PENDENTE, EXPIRADO ou CORTESIA.',
                'FIF_data_liberacao.required' => 'O campo data de liberação FIF é obrigatório.',
                'FIF_data_liberacao.date' => 'A data de liberação FIF deve ser uma data válida.',
                'data_contrato.required' => 'O campo data do contrato é obrigatório.',
                'data_contrato.date' => 'A data do contrato deve ser uma data válida.',
                'bloqueio_status_financ.boolean' => 'O status de bloqueio financeiro deve ser verdadeiro ou falso.',
                'status_produto_preco.boolean' => 'O status do produto/preço deve ser verdadeiro ou falso.',
            ])->validate();

            // Não strip o código_fiscal aqui também (consistência com store atualizado)
            // $validatedData['codigo_fiscal'] = preg_replace('/[^0-9]/', '', $validatedData['codigo_fiscal']);

            // Atualização do registro no banco de dados
            $empresa->update([
                'id_grupo' => $validatedData['grupo_empresarial'],
                'nome_fantasia' => $validatedData['nome_fantasia'],
                'razao_social' => $validatedData['razao_social'],
                'codigo_fiscal' => $validatedData['codigo_fiscal'],
                'email_contato' => $validatedData['email_contato'],
                'grupo_classificacao' => $validatedData['grupo_classificacao'],
                'modalidade' => $validatedData['modalidade'],
                'ultima_renovacao' => $validatedData['ultima_renovacao_contrato'],
                'ultima_renovacao_tipo' => $validatedData['ultima_renovacao_tipo'],
                'FIF_status' => $validatedData['fif_status'],
                'FIF_data_liberacao' => $validatedData['FIF_data_liberacao'],
                'data_contrato' => $validatedData['data_contrato'],
                'bloqueio_status_financ' => $validatedData['bloqueio_status_financ'],
                'status_produto_preco' => $validatedData['status_produto_preco'],
            ]);

            // Redireciona com mensagem de sucesso
            return redirect()->route('empresa.index')->with('success', 'Empresa ' . $request->razao_social . ' atualizada com sucesso!');
        } catch (ValidationException $e) {
            // Captura erros de validação e retorna ao formulário com os erros
            Log::error('Erro de validação ao atualizar empresa: ' . $e->getMessage(), [
                'errors' => $e->validator->errors(),
                'data' => $request->all(),
                'empresa_id' => $empresa->id
            ]);
            return redirect()->back()
                ->withErrors($e->validator->errors())
                ->withInput();
        } catch (\Exception $e) {
            // Log do erro para outros tipos de exceções
            Log::error('Erro ao atualizar empresa: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => $request->all(),
                'empresa_id' => $empresa->id
            ]);

            // Retorna com mensagem de erro genérica (back pro modal)
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao atualizar a empresa. Tente novamente ou contate o administrador.')
                ->withInput();
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
