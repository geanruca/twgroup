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
                 <b> Título:</b>  <span> {{$publication->title}}  </span> 

                   <span class="float-right"> <b>Escrito por:</b>   {{$publication->user->name}}</span>
            </div>

                <div class="card-body">

                    <div class="modal-header">
                        <h5 class="modal-title">Editar Publicación</h5>
                    </div>
                    <div class="modal-body">
                    
                        <form method="POST" action="{{route('publications.update', $publication->id)}}">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="title">Título</label>
                                <input type="text" required name="title" class="form-control" value="{{$publication->title}}" > 
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contenido</span>
                                </div>
                                <textarea required  min="1" max="100" class="form-control" name="content" aria-label="Contenido">{{$publication->content}}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary float-right mt-2">Guardar</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
