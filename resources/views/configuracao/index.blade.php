@extends('home')
@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Preço Bilhete</th>
                <th scope="col">Iva</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($configs as $conf)
            <tr>
                <td>{{$conf->preco_bilhete_sem_iva}}</td>
                <td>{{$conf->percentagem_iva}}</td>
                <td>
                <a href="{{ route('configuracao.update', $conf->id) }}" name="conf" value="1" class="btn btn-secondary btn-sm" role="button" aria-pressed="true">Alterar</a>
                </td>
            @endforeach
        </tbody>
    </table>
@endsection