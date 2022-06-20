@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Salas</h1></strong></h3>
</div>
<br>
<form  action="{{route('salas.index')}}" method="GET">
<div class="row mb-2">
    <div class="col-sm-5 col-md-5">
        <!-- Nome -->
        <input type="search" name="nome" id="nome" class="form-control rounded" placeholder="Pesquisar por Nome ou Email" aria-label="Search" aria-describedby="search-addon" />    
        <!-- Nome --> 
    </div>
    <div class="col-sm-5 col-md-5">
    
        <!-- estado -->
        <select class="form-select" name="estado" id="inputGroupSelect04">
                <option value="Todas" >
                Todas
                </option>
                <option value="Ativas">
                Ativas
                </option>
                <option value="Inativas">
                Inativas
                </option>
        </select>
        <!-- estado -->
    </div>  
    <div class="col-sm-5 col-md-2 .ml-md-auto" >
        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-search"></i> Pesquisar</button>
    </div>
</div>
</form> 
<br>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Sala</th>
                <th scope="col">Lotação</th>
                <th scope="col"></th>
                <th scope="col">
                    <form method="get" action="{{route('salas.create')}}">
                        <button style="float: right;" class="btn btn-outline-dark" href="{{route('salas.store')}}">Nova Sala</button>
                    </form>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($todassalas as $salas)
            <tr>
            
                <td>{{$salas->nome}}</td>
                <td>{{$salas->custom}}</td>
                <td>
                @if($salas->deleted_at == null)
                <a style="float: right;" class="btn btn-outline-dark" href="{{ route('salas.edit', $salas) }}" name="salaid" value='{{$salas}}' role="button" aria-pressed="true">Alterar</a>
                @endif
                </td>
                
                <td>
                @if($salas->deleted_at == null)
                <form  action="{{route('salas.index.recuperar')}}" method="GET">
                    <input type="hidden" id="id" name="id" value="{{$salas->id}}">
                    <button style="float: right;" type="submit" class="btn btn-outline-danger">&nbsp&nbspEliminar&nbsp&nbsp</button>              
                </form>
                @else
                <form  action="{{route('salas.index.recuperar')}}" method="GET">
                    <input type="hidden" id="id" name="id" value="{{$salas->id}}">
                    <button style="float: right;" type="submit" class="btn btn-outline-success">Recuperar</button>
                </form>
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
            {!! $todassalas->links() !!}
    </div>   
@endsection