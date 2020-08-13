<?php

namespace App\Http\Controllers;

use App\User;
use App\Comment;
use App\Publication;
use Illuminate\Http\Request;
use App\Mail\NuevoComentario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'content'=>'required',
            'publication_id'=>'required',
        ]);
        //validacion especial
        $ya_tiene_comentario = Publication::where('id', $r->publication_id)
            ->whereHas('comments',function($q){
                $q->where('user_id', auth()->user()->id);
            })->first();

        if($ya_tiene_comentario){
            return redirect()->back()->with('warning', 'Ud. ya ha realizado un comentario')->with(compact('ya_tiene_comentario'));
        }

        
        Comment::create([
            'user_id'        => auth()->user()->id,
            'publication_id' => $r->publication_id,
            'content'        => $r->content,
            'status'         => "APROBADO",
        ]);

        $author_publication = User::where('id', Publication::find($r->publication_id)->user_id)->first();
        $author_comment     = Auth::user();
        
        Mail::to($author_publication->email)
            ->queue(new NuevoComentario($author_comment->name, $r->content));

        return redirect()->back()->with('listo', 'Se ha agregado su comentario');

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
        $comment = Comment::where('id',$id)->first();

        return view('publications.edit_comment', compact('comment'));
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
        Comment::find($id)->update([
            'title'   => $r->title,
            'content' => $r->content
        ]);
        return redirect()->route('publications.index')->with('listo','Comentario editado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comment::where('id',$id)->delete();
        return redirect()->route('publications.index')->with('listo', 'Comentario eliminado');
    }
}
