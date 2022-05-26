@extends('home')

@section('content')
<form method="get" action="{{route('sessoes.admin.create')}}">
    <button class="btn btn-secondary" href="{{route('sessoes.admin.store')}}">Novo</button>
</form> 
<div class="text-center">
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Dia Sessao</th>
            <th scope="col">Hora</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sessoesFilme as $sessao)
                <tr>
                    <td name="data" value="<?= $sessao->data ?>"><?= $sessao->data ?></td>
                    <td name="horario_inicio" value="<?= $sessao->horario_inicio ?>"><?= $sessao->horario_inicio ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>                    
                    <td><a href="{{ route('sessoes.admin.edit', $sessao->id) }}" name="sessaoid" value='{{$sessao->id}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                    <td>
                    <form method="post" action="{{ route('sessoes.admin.destroy', $sessoes->id) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" value="Eliminar">
                    </form>
                    </td>
                </tr>
            @endforeach
    </tbody>   
</div>
@endsection