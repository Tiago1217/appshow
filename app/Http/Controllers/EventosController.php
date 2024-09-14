<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventos; // Fixed the namespace to match the model file location
use Illuminate\Support\Facades\Redirect;

class EventosController extends Controller
{
    // Para mostrar tela administrativa
    public function MostraHome()
    {
        return view('homeadm');
    }

    // Para mostrar tela de cadastro de eventos
    public function MostrarCadastroEvento()
    {
        return view('cadastroevento');
    }

    // Para salvar os registros na tabela eventos
    public function CadastrarEventos(Request $request)
    {
        $validatedData = $request->validate([
            'nomeEvento' => 'string|required',
            'dataEvento' => 'date|required',
            'localEvento' => 'string|required',
            'imgEvento' => 'string|required',
        ]);

        Eventos::create($validatedData);
        return Redirect::route('home-adm');
    }

    // Para apagar os registros na tabela de eventos
    public function destroy($id)
    {
        $event = Eventos::findOrFail($id);
        $event->delete();
        return Redirect::route('home-adm');
    }

    // Para alterar os registros na tabela de eventos
    public function Update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nomeEvento' => 'string|required',
            'dataEvento' => 'date|required',
            'localEvento' => 'string|required',
            'imgEvento' => 'string|required',
        ]);

        $event = Eventos::findOrFail($id);
        $event->update($validatedData);

        return Redirect::route('home-adm');
    }

    // Para mostrar somente os eventos por id
    public function MostrarEventoCodigo($id)
    {
        $event = Eventos::findOrFail($id);
        return view('altera-evento', ['registroEvento' => $event]);
    }

    // Para mostrar os eventos por nome
    public function MostrarEventoNome(Request $request)
    {
        $registros = Eventos::query();
        $registros->when($request->nomeEvento, function ($query, $valor) {
            $query->where('nomeEvento', 'like', '%' . $valor . '%');
        });

        $todosRegistros = $registros->get();
        return view('listaEventos', ['registrosEventos' => $todosRegistros]);
    }
}
