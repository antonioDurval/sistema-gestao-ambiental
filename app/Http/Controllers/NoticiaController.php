<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Http\Requests\NoticiaRequest;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Noticia::all();
        return view('noticia.index', compact('noticias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('noticia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\NoticiaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticiaRequest $request)
    {
        $noticia = new Noticia();
        $noticia->setAtributes($request);
        $noticia->save();
        $noticia->salvarImagem($request->imagem_principal);
        $noticia->update();

        return redirect(route('noticias.index'))->with(['success' => 'Notícia salva com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $noticia = Noticia::find($id);
        return view('noticia.edit', compact('noticia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Requests\NoticiaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NoticiaRequest $request, $id)
    {
        $noticia = Noticia::find($id);
        $noticia->setAtributes($request);

        if ($request->imagem_principal != null) {
            $noticia->salvarImagem($request->imagem_principal);
        }

        $noticia->update();
        return redirect(route('noticias.index'))->with(['success' => 'Notícia atualizada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Visualizar notícia.
     *
     * @param  string $titulo
     * @return \Illuminate\Http\Response
     */
    public function visualizar($titulo) 
    {
        $noticia = Noticia::where('link', route('noticias.visualizar', ['titulo' => $titulo]))->first();
        
        return view('noticia.visualizar', compact('noticia'));
    }
}
