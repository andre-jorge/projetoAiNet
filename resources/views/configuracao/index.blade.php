@extends('home')
@section('content')
<div class="container text-center"
<h3 class="align-middle"><strong><h1 class="align-middle">Preços Bilhetes</h1></strong></h3>
</div>
<br>
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
                <a href="{{ route('configuracao.update', $conf->id) }}" name="conf" value="1" class="btn btn-outline-dark" role="button" aria-pressed="true">Alterar</a>
                </td>
            @endforeach
        </tbody>
    </table>
@endsection