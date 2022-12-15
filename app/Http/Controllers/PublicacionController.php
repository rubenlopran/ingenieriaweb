<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class PublicacionController
 * @package App\Http\Controllers
 */
class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('filtro') == null){
            $publicacions = Publicacion::orderBy('updated_at','desc')->paginate();
        }else{
            $publicacions = Publicacion::where('descripcion','LIKE',"%{$request->get('filtro')}%")->orderBy('updated_at','desc')->paginate();
        }

        return view('publicacion.index', compact('publicacions'))
            ->with('i', (request()->input('page', 1) - 1) * $publicacions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $publicacion = new Publicacion();
        return view('publicacion.create', compact('publicacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request["like"]=0;
        $request["user_id"]=Auth::user()->id;
        request()->validate(Publicacion::$rules);
        $publicacion = Publicacion::create($request->all());
        $publicacion->url = time().'.'.$request->url->getClientOriginalExtension();
        $request->url->move(public_path('images'), $publicacion->url);
        $publicacion->save();


        return redirect()->route('publicacions.index')
            ->with('success', 'Publicacion created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publicacion = Publicacion::find($id);

        return view('publicacion.show', compact('publicacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publicacion = Publicacion::find($id);

        return view('publicacion.edit', compact('publicacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Publicacion $publicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publicacion $publicacion)
    {
        request()->validate(Publicacion::$rules);

        $publicacion->update($request->all());

        $publicacion->url = time().'.'.$request->url->getClientOriginalExtension();
        $request->url->move(public_path('images'), $publicacion->url);
        $publicacion->save();


        return redirect()->route('publicacions.index')
            ->with('success', 'Publicacion updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $publicacion = Publicacion::find($id)->delete();

        return redirect()->route('publicacions.index')
            ->with('success', 'Publicacion deleted successfully');
    }
}
