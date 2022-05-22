@extends('home')

@section('content')

<h2>Cursos</h2>
<div class="genero-area">
    @foreach($generos as $genero)
    <div class="genero">
        <div class="genero-info-area">
            <div class="genero-info">
                <span class="genero-label">Codigo</span>
                <span class="genero-info-desc">{{$genero->code}}</span>
            </div>
            <div class="genero-info">
                <span class="genero-label">Nome</span>
                <span class="genero-info-desc">{{$genero->nome}}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection