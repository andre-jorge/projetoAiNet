@extends('home')

@section('content')

<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" action="{{ route('carrinho.store_sessao', $sessao)}}" method="POST">
@csrf    

<div class="search-item">
            <!-- GENERO -->
            <select name="fila">
            @foreach ($lugares as $lugar)
                <option value="{{ $lugar->fila }}.{{$lugar->posicao}}">{{ $lugar->fila }}  {{$lugar->posicao}}</option>
                <input type="hidden" name="posicao" value="{{$lugar->posicao}}" style="display:none">
            @endforeach
            
            
            </select>
           
        <button class="btn btn-primary" type="submit">teste</button>
    </div>
</form>




@endsection