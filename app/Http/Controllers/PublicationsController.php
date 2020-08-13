<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::orderby('updated_at','desc')->get();
        return view('publications.index', compact('publications'));
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
    public function store(Request $r)
    {
        $r->validate([
            'title'=>'required',
            'content'=>'required',
        ]);
        $user = Auth::user();
        Publication::create([
            'title'=>$r->title,
            'content'=>$r->content,
            'user_id'=>$user->id,
        ]);
        return redirect()->back()->with('listo','Publicación creada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publication = Publication::where('id',$id)->with('comments', 'user')->first();
        $ya_tiene_comentario = Publication::where('id', $id)
            ->whereHas('comments',function($q){
                $q->where('user_id', auth()->user()->id);
            })->first();

        return view('publications.show', compact('publication', 'ya_tiene_comentario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publication = Publication::where('id',$id)->with('comments', 'user')->first();

        return view('publications.edit', compact('publication'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, $id)
    {
        Publication::find($id)->update([
            'title'=>$r->title,
            'content'=>$r->content
        ]);
        return redirect()->route('publications.index')->with('listo','Publicación creada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Publication::where('id',$id)->delete();

        return redirect()->route('publications.index')->with('listo', 'Publicación eliminada');
    }
}
