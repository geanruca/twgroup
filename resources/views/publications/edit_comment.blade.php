@extends('layouts.app')

@section('content')
<div class="container ">
    @if(session()->has('listo'))
    <div class="alert alert-success">
        {{ session()->get('listo') }}
    </div>
    @endif
    @if(session()->has('warning'))
    <div class="alert alert-warning">
        {{ session()->get('warning') }}
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header"> 
                 <b> Título:</b>  <span> {{$comment->title}}  </span> 

            </div>

                <div class="card-body">

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Comentario</h5>
                    </div>
                    <div class="modal-body">
                    
                        <form method="POST" action="{{route('comments.update', $comment->id)}}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contenido</span>
                                </div>
                                <textarea required  min="1" max="100" class="form-control" name="content" aria-label="Contenido">{{$comment->content}}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary float-right mt-2">Guardar</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
