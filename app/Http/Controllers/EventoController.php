<?php

namespace App\Http\Controllers;

use App\Evento;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class EventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $evento;

    public function __construct(Evento $evento)
    {
        $this->evento = $evento;
    }

    public function index(Request $request)
    {

        $eventos = $this->evento;
        $eventos = $eventos->where('nomeEvento', 'LIKE', "%{$request->nomeEvento}%")->orderBy('acessos', 'desc')->get();
        return response()->json($eventos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $evento = $this->evento;

        $evento = $evento->create($data);
        return response()->json($evento);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evento = $this->evento::find($id);

        return response()->json($evento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $evento = $this->evento::find($id);

        $evento = $evento->update($data);
        return response()->json($evento);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evento = $this->evento::find($id);
        $evento = $evento->delete();
        return response()->json($evento);
    }

    public function acessos($id){
        $evento = $this->evento::find($id);
        $acessos = $evento['acessos']+1;
        $evento = $evento->update(['acessos'=>$acessos]);
        return response()->json($evento);
    }
}
