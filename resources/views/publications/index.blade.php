@extends('layouts.app')

@section('content')
<div class="container ">
    @if(session()->has('listo'))
    <div class="alert alert-success">
        {{ session()->get('listo') }}
    </div>
@endif
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Publicaciones
                    <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                        Agregar nueva publicación
                    </button>
                </div>
                

                <div class="card-body">
                    <!-- Button trigger modal -->
                        <div class="row mt-5">
                            <div class="col-2 ">
                                <b>Titulo</b>
                            </div>
                            <div class="col-8 ">
                                <b>Contenido</b>
                            </div>
                            <div class="col-2 ">
                                <b>Última actualización</b>
                            </div>
                        </div>
                            @forelse ($publications as $p)
                                <div class="row"> 
                                    <div class="col-2 ">
                                    <span> <a href="publications/{{$p->id}}">{{$p->title}}</a></span>
                                    </div>
                                    <div class="col-6 ">
                                        <span>{{$p->content}}</span>
                                    </div>
                                    <div class="col-2 ">
                                        <span>{{$p->updated_at->diffForHumans()}}</span>
                                    </div>
                                    <div class="col-2 ">
                                        @if($p->user_id == auth()->user()->id)
                                            <a class="btn btn-info text-white" href="{{route('publications.edit', $p->id)}}">
                                                Editar
                                            </a>
                                            <form action="{{route('publications.destroy',$p->id)}}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit"  class="btn btn-danger">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @empty
                            @endforelse       
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Publicación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        
            <form method="POST" action="{{url('publications')}}">
                @csrf
                <div class="form-group">
                  <label for="title">Título</label>
                  <input type="text" required name="title" class="form-control" id="title" max="50" aria-describedby="emailHelp" placeholder="Ingrese titulo">
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Contenido</span>
                    </div>
                    <textarea required min="1" max="100" class="form-control" name="content" aria-label="Contenido"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary float-right mt-2">Guardar</button>
              </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
    </div>
    </div>
</div>

@endsection
