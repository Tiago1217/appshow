<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventos; // Importa o modelo de Eventos
use Illuminate\Support\Facades\Redirect; // Importa a fachada para redirecionamentos

class EventosController extends Controller
{
    // Para mostrar a tela administrativa
    public function MostraHome()
    {
        return view('homeadm'); // Retorna a view homeadm
    }

    // Para mostrar a tela de cadastro de eventos
    public function MostrarCadastroEvento()
    {
        return view('cadastroevento'); // Retorna a view para cadastro de eventos
    }

    // Para salvar os registros na tabela eventos
    public function CadastrarEventos(Request $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'nomeEvento' => 'string|required', // Nome do evento deve ser uma string e é obrigatório
            'dataEvento' => 'date|required', // Data do evento deve ser uma data e é obrigatória
            'localEvento' => 'string|required', // Local do evento deve ser uma string e é obrigatório
            'imgEvento' => 'image|required', // Imagem do evento deve ser um arquivo de imagem e é obrigatório
        ]);

        // Cria um novo registro no banco de dados usando os dados validados
        Eventos::create($validatedData);
        // Redireciona para a página inicial com uma mensagem de sucesso
        return Redirect::route('home-adm')->with('success', 'Evento cadastrado com sucesso!');
    }

    // Para apagar os registros na tabela de eventos
    public function destroy($id)
    {
        // Busca o evento pelo ID e falha se não encontrado
        $event = Eventos::findOrFail($id);
        // Deleta o evento encontrado
        $event->delete();
        // Redireciona para a página inicial com uma mensagem de sucesso
        return Redirect::route('home-adm')->with('success', 'Evento apagado com sucesso!');
    }

    // Para alterar os registros na tabela de eventos
    public function Update(Request $request, $id)
    {
        // Validação dos dados recebidos para atualização
        $validatedData = $request->validate([
            'nomeEvento' => 'string|required', // Nome do evento deve ser uma string e é obrigatório
            'dataEvento' => 'date|required', // Data do evento deve ser uma data e é obrigatória
            'localEvento' => 'string|required', // Local do evento deve ser uma string e é obrigatório
            'imgEvento' => 'image|required', // Imagem do evento deve ser um arquivo de imagem e é obrigatório
        ]);

        // Busca o evento pelo ID e falha se não encontrado
        $event = Eventos::findOrFail($id);
        // Atualiza o evento com os novos dados validados
        $event->update($validatedData);
        // Redireciona para a página inicial com uma mensagem de sucesso
        return Redirect::route('home-adm')->with('success', 'Evento atualizado com sucesso!');
    }

  // Para mostrar somente os eventos por ID
public function MostrarEventoCodigo(Eventos $id)
{
    // Busca o evento pelo ID e falha se não encontrado
    $event = Eventos::findOrFail($id);
    // Retorna a view de alteração com os dados do evento
    return view('alteraevento', ['registroEvento' => $event]); // Mudei aqui para passar o objeto do evento
}


    // Para mostrar os eventos por nome
    public function MostrarEventoNome(Request $request)
    {
        // Cria uma consulta para buscar eventos
        $registros = Eventos::query();
        // Filtra os eventos se um nome for fornecido na requisição
        $registros->when($request->nomeEvento, function ($query, $valor) {
            $query->where('nomeEvento', 'like', '%' . $valor . '%'); // Busca eventos que contêm o nome fornecido
        });

        // Obtém todos os registros filtrados
        $todosRegistros = $registros->get();
        // Retorna a view de lista de eventos com os registros encontrados
        return view('listaEventos', ['registrosEventos' => $todosRegistros]);
    }
}
