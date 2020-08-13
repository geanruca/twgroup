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

                    <p>
                        <span> <b>Última actualización:</b>  {{$publication->updated_at->diffForHumans()}} </span> 
                    </p>

                    <p>
                       {{$publication->content}}
                    </p> 

                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-2 ">
            <b>Escrito por</b>
        </div>
        <div class="col-6 ">
            <b>Contenido</b>
        </div>
        <div class="col-2 ">
            <b>Última actualización</b>
        </div>
        <div class="col-2 ">
            <b>Actions</b>
        </div>
    </div>

    @forelse ($publication->comments as $c)
        <div class="row"> 
            <div class="col-2 ">
                <span> {{Auth::user($c->user_id)->name}}</span>
            </div>
            <div class="col-6 ">
                <span>{{$c->content}}</span>
            </div>
            <div class="col-2 ">
                <span>{{$c->updated_at->diffForHumans()}}</span>
            </div>
            <div class="col-2 ">
                @if($c->user_id == auth()->user()->id)
                    <a class="btn btn-info text-white" href="{{route('comments.edit', $c->id)}}">
                        Editar
                    </a>
                    <form action="{{route('comments.destroy',$c->id)}}" method="POST">
                    <button type="submit" class="btn btn-danger">
                        @method('DELETE')
                        @csrf
                        Eliminar
                    </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
    <div class="row justify-content-center mt-5">
        <p>No hay comentarios aún</p>
    </div>
    @endforelse
    @if(!$ya_tiene_comentario)
    <button type="button" class="btn btn-primary float-left mt-5" data-toggle="modal" data-target="#exampleModal">
        Agregar nuevo comentario
    </button>
    @endif


</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo comentario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        
            <form method="POST" action="{{url('comments')}}">
                @csrf
                <input type="hidden" name="publication_id" value="{{$publication->id}}">
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Comentar</span>
                    </div>
                    <textarea required min="1" max="100" class="form-control" name="content" aria-label="Contenido"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary mt-2 float-right">Guardar</button>
              </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
    </div>
</div>
@endsection
