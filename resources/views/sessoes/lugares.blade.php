@extends('home')

@section('content')

<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="{{ route('carrinho.store_sessao', $sessao)}}" method="POST">
@csrf    

<div class="search-item">
            <!-- FILA -->
            <select name="idlugar">
            @foreach ($lugares as $lugar)
                <option value="{{ $lugar->id }}">{{ $lugar->fila }} - {{$lugar->posicao}}</option>
            @endforeach
            </select>   
        <button class="btn btn-primary" type="submit">teste</button>
    </div>
</form>




@endsection