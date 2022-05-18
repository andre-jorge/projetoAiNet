@extends('home')

@section('content')
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Filmes em Destaques</h1>
                <div class="text-center" name="sess" id="idSess">
                    <form class="sess-search" action="#" method="GET">
                        <div class="search-item">
                                <div name="Fil" id="idFilme">
                                    @foreach ($FilmeSessoes as $fil)
                                        <a value="{{$fil->id}}">{{$fil->data}} - {{$fil->horario_inicio}}</a>
                                    @endforeach
                                </div>
                        </div>
                        <div class="search-item">
                            <button type="submit" class="bt" id="btn-filter">Filtrar</button>
                        </div>
                    </form>                          
                </div>
        </div>

        </div>
        </div>
    </div>
    <div>
</div>
@endsection