@extends('home')

@section('content')
<div class="text-center">
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Dia Sessao</th>
            <th scope="col">Hora</th>
            <th scope="col">Sala</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sessoesFilme as $sessao)
                <tr>
                    <td name="data" value="<?= $sessao->data ?>"><?= $sessao->data ?></td>
                    <td name="horario_inicio" value="<?= $sessao->horario_inicio ?>"><?= $sessao->horario_inicio ?></td>
                    <td name="sala_id" value="<?= $sessao->Salas->nome ?>"><?= $sessao->Salas->nome ?></td>
                    <td></td>
                    <td></td>
                    <td></td>                    
                    <td><a href="{{ route('sessoes.admin.edit', $sessao) }}" name="sessao" value='{{$sessao}}' class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                    <td>
                    <form method="post" action="{{ route('sessoes.admin.destroy', $sessao) }}">
                        @method('DELETE')
                        @csrf
                        <input type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Pretende eleminar?')" value="Eliminar">
                    </form>
                    </td>
                </tr>
            @endforeach
    </tbody>   
</div>
@endsection