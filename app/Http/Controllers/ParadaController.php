<?php

namespace App\Http\Controllers;

use App\Models\Parada;
use Illuminate\Http\Request;

/**
 * Class ParadaController
 * @package App\Http\Controllers
 */
class ParadaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lineas = Parada::all()->add(null)->pluck('codLinea', 'codLinea');
        $sentidos = Parada::all()->add(null)->pluck('sentido', 'sentido');
        $filtrolineas = $request->get('codLinea');
        $filtrosentido = $request->get('sentido');
        if($filtrolineas != null && $filtrosentido==null){ 
            $paradas = Parada::where('codLinea','LIKE',"{$filtrolineas}")->paginate();
        } else if($filtrosentido != null && $filtrolineas==null){ 
            $paradas = Parada::where('sentido','=',"{$filtrosentido}")->paginate();
        } else if($filtrolineas != null && $filtrosentido!=null){ 
            $paradas = Parada::where('sentido','LIKE',"%{$filtrosentido}%")->where('codLinea','LIKE',"%{$request->get('filtrolinea')}%")->paginate();
        } 
        else if($request->get('filtroparada') != null){
            $paradas = Parada::where('nombreParada','LIKE',"%{$request->get('filtroparada')}%")->paginate();
        } 
        else if($request->get('filtrodireccion') != null){
            $parada = Parada::where('direccion','LIKE',"%{$request->get('filtrodireccion')}%");
            $paradas = Parada::where('lat','<',"{$parada->get('lat')}")->paginate();
        } else{
            $paradas = Parada::paginate();
        }
        return view('parada.index', compact('paradas','lineas','sentidos'))
            ->with('i', (request()->input('page', 1) - 1) * $paradas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parada = new Parada();
        return view('parada.create', compact('parada'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Parada::$rules);

        $parada = Parada::create($request->all());

        return redirect()->route('paradas.index')
            ->with('success', 'Parada created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parada = Parada::find($id);

        return view('parada.show', compact('parada'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parada = Parada::find($id);

        return view('parada.edit', compact('parada'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Parada $parada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parada $parada)
    {
        request()->validate(Parada::$rules);

        $parada->update($request->all());

        return redirect()->route('paradas.index')
            ->with('success', 'Parada updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $parada = Parada::find($id)->delete();

        return redirect()->route('paradas.index')
            ->with('success', 'Parada deleted successfully');
    }
}
